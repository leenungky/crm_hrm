<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use PHPExcel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Helpers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use \URL;
use \PHPExcel_IOFactory, \PHPExcel_Style_Fill, \PHPExcel_Cell, \PHPExcel_Cell_DataType, \SiteHelpers;

class PayrollController extends Controller {
    
    var $data;
    var $company_id;
    public function __construct(Request $req){
        $this->data["type"]= "master_payroll";  
        $this->data["req"] = $req;              
        $this->company_id = \Auth::user()->company_id;
        $this->data["helper"] = new Helpers();
        $this->data["ctrl"] = $this;
    }

    public function getList(){                                                   
        return view('payroll.index', $this->data);
    }

    public function getTree(){           
        $payrollDB = $this->_get_index_filter();                                  
        $payrollDB = $payrollDB->where("parent_id", 0);    
        $payrollDB = $payrollDB->get();                        
        $this->data["payrollDB"] = $payrollDB;           
        return view('payroll.tree', $this->data);
    }

    public function postCreate($id){        
        $req = $this->data["req"];
        $validator = Validator::make($req->all(), [            
            'name' => 'required'          
        ]);

        if ($validator->fails()) {            
            return Redirect::to(URL::previous())->withInput(Input::all())->withErrors($validator);            
        }
        $arrInsert = $req->input();
        if ($id!="root"){
            $arrInsert["parent_id"] = $id;    
        }        
        $arrInsert["created_at"] = date("Y-m-d h:i:s");
        $arrInsert["company_id"] = $this->company_id;
        unset($arrInsert["_token"]);        
        $payroll = DB::table("payroll")->where("company_id", $this->company_id)->where("name", $arrInsert["name"])->first();        
        if (isset($payroll)){
            return redirect('/payroll/list')->with('message', $arrInsert["name"]." sudah digunakan");            
        }else{
            DB::table("payroll")->insert($arrInsert); 
            DB::statement("ALTER TABLE employee_payroll ADD ".  str_replace(' ', '_', strtolower($arrInsert["name"]))." VARCHAR(60)");
            if ($id!="root"){
                DB::table("payroll")->where("id", $id)->update(array("is_group" =>1));       
            }    
            return redirect('/payroll/list')->with('message', "Successfull create");
        }
        
        
    }

    public function getEdit($id){
        $payroll = DB::table("payroll")->where("id", $id)->where("company_id", $this->company_id)->first();        
        $this->data["payroll"] = $payroll;
        return view('payroll.edit', $this->data);        
    }

    public function getDelete($id){
        $req = $this->data["req"]; 
        if ($id=="root"){
            DB::table("payroll")->where("company_id", $this->company_id)->delete();                
        }else{
            $department = DB::table("payroll")->where("company_id", $this->company_id)->where("id", $id)->first();
            $department_child = DB::table("payroll")
                ->where("company_id", $this->company_id)
                ->where("parent_id", $department->parent_id)
                ->where("id","<>", $id)
                ->get();            
            if (empty($department_child)){                
                DB::table("payroll")->where("company_id", $this->company_id)->where("id", $department->parent_id)->update(array("is_group"=>0));
            }

            $this->dropField($id);            
            DB::table("payroll")->where("parent_id", $id)->where("company_id", $this->company_id)->delete();                
            DB::table("payroll")->where("id", $id)->where("company_id", $this->company_id)->delete(); 
        }        
        return redirect('/payroll/list')->with('message', "Successfull delete");
    }

    public function getNew(){
        $req= $this->data["req"];
        $this->data["parent_id"] = $req->get("id");                
        return view('payroll.new', $this->data);
    }

    public function postUpdate($id){
        $req = $this->data["req"];
        $arrInsert = $req->input();        
        unset($arrInsert["_token"]);        
        $customer = DB::table("payroll")->where("id", $id)->update($arrInsert);        
        return redirect('/payroll/list')->with('message', "Successfull update");
    }

    public function _get_index_filter($filter = null){
        $dbcust = DB::table("payroll")->where("company_id", $this->company_id);        
        return $dbcust;
    }

    private function dropField($id){
        $payrolls = DB::table("payroll")->select("name")->where("parent_id", $id)->where("company_id", $this->company_id)->get();                
        if (isset($payrolls)){
            foreach ($payrolls as $key => $value) {
                DB::statement("ALTER TABLE employee_payroll drop ".  str_replace(' ', '_', strtolower($value->name)));
            }
        }
        $payroll = DB::table("payroll")->select("name")->where("id", $id)->where("company_id", $this->company_id)->first(); 
        if (isset($payroll)){
            DB::statement("ALTER TABLE employee_payroll drop ".  str_replace(' ', '_', strtolower($payroll->name)));
        }
    }

    
}
    
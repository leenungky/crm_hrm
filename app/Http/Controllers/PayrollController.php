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
use \Schema;
    

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
        $payroll = DB::table("payroll_component")->where("company_id", $this->company_id)->where("name", $arrInsert["name"])->first();        
        if (isset($payroll)){
            return redirect('/payroll/list')->with('message', $arrInsert["name"]." sudah digunakan");            
        }else{
            $field_name = str_replace(' ', '_', strtolower($arrInsert["name"]));
            if (isset($arrInsert["is_master"])){
                if(!Schema::hasColumn('employee_payroll_master', $field_name)) { 
                    DB::statement("ALTER TABLE employee_payroll_master ADD ". $field_name  ." VARCHAR(60)");
                }
                $arrInsert["is_master"] = 1;
            }
            $arrInsert["field"] = $field_name;
            DB::table("payroll_component")->insert($arrInsert);
            if(!Schema::hasColumn('employee_payroll', $field_name)) { 
                    DB::statement("ALTER TABLE employee_payroll ADD ". $field_name." VARCHAR(60)");
            }
            if ($id!="root"){
                DB::table("payroll_component")->where("id", $id)->update(array("is_group" =>1));       
            }    

            return redirect('/payroll/list')->with('message', "Successfull create");
        }
    
    }
    
    public function getEdit($id){
        $payroll = DB::table("payroll_component")->where("id", $id)->where("company_id", $this->company_id)->first();        
        return response()->json(array("response"=> array('code' => '200', 'message' => 'Successfull created'), "data"=> $payroll));          
    }

    public function getDelete($id){
        $req = $this->data["req"]; 
        if ($id=="root"){
            DB::table("payroll")->where("company_id", $this->company_id)->delete();                
        }else{
            $department = DB::table("payroll_component")->where("company_id", $this->company_id)->where("id", $id)->first();
            $department_child = DB::table("payroll_component")
                ->where("company_id", $this->company_id)
                ->where("parent_id", $department->parent_id)
                ->where("id","<>", $id)
                ->get();            
            if (empty($department_child)){                
                DB::table("payroll_component")->where("company_id", $this->company_id)->where("id", $department->parent_id)->update(array("is_group"=>0))
;            }
            $this->dropField($id);            
            DB::table("payroll_component")->where("parent_id", $id)->where("company_id", $this->company_id)->delete();                
            DB::table("payroll_component")->where("id", $id)->where("company_id", $this->company_id)->delete(); 
        }        
        return redirect('/payroll/list')->with('message', "Successfull delete");
    }

    public function getNew(){
        $req= $this->data["req"];
        $this->data["parent_id"] = $req->get("id");                
        return response()->json(array("response"=> array('code' => '200', 'message' => 'Successfull created'), "data"=> $this->data["parent_id"]));          
    }

    public function postUpdate($id){
        $req = $this->data["req"];
        $arrInsert = $req->input();        
        $payroll = DB::table("payroll_component")->where("company_id", $this->company_id)->where("id", $id)->first();
        unset($arrInsert["_token"]);                 
        if (isset($arrInsert["is_master"])){
            unset($arrInsert["is_master"]);                                
            $arrInsert["is_master"] = 1;         
            if(!Schema::hasColumn('employee_payroll_master', $payroll->field)) {         
                DB::statement("ALTER TABLE employee_payroll_master ADD ". $payroll->field  ." VARCHAR(60)");
            }
        }else{            
            if(Schema::hasColumn('employee_payroll_master', $payroll->field)) {         
                DB::statement("ALTER TABLE employee_payroll_master drop ".  $payroll->field);           
            }            
            $arrInsert["is_master"] = 0;
        }     
        DB::table("payroll_component")->where("id", $id)->where("company_id", $this->company_id)->update($arrInsert);        
        return redirect('/payroll/list')->with('message', "Successfull update");
    }



    public function _get_index_filter($filter = null){
        $dbcust = DB::table("payroll_component")->where("company_id", $this->company_id);        
        return $dbcust;    
    }

    private function dropField($id){
        $payrolls = DB::table("payroll_component")->select("is_master","name")->where("parent_id", $id)->where("company_id", $this->company_id)->get();                
        if (isset($payrolls)){
            foreach ($payrolls as $key => $value) {
                $field_name = str_replace(' ', '_', strtolower($value->name));
                if(Schema::hasColumn('employee_payroll', $field_name)) { 
                    DB::statement("ALTER TABLE employee_payroll drop ".  $field_name);
                }
                
                if ($value->is_master==1){                    
                    if(Schema::hasColumn('employee_payroll', $field_name)) { 
                        DB::statement("ALTER TABLE employee_payroll drop ".  $field_name);    
                    }
                }
                
            }
        }
        $payroll = DB::table("payroll_component")->select("name","is_master")->where("id", $id)->where("company_id", $this->company_id)->first(); 
        if (isset($payroll)){
            $field_name = str_replace(' ', '_', strtolower($payroll->name));
            if(Schema::hasColumn('employee_payroll', $field_name)) { 
                    DB::statement("ALTER TABLE employee_payroll drop ".  $field_name); 
            }
            if ($payroll->is_master==1){
                if(Schema::hasColumn('employee_payroll_master', $field_name)) { 
                        DB::statement("ALTER TABLE employee_payroll_master drop ".  $field_name);
                }
            }
        }
    }

    
}
    
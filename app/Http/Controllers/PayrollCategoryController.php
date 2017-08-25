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

class PayrollCategoryController extends Controller {
    
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
        $paycatDB = $this->_get_index_filter();
        $paycatDB = $paycatDB->get();   
        $paycat_employe = DB::table("paycat_employe")
            ->select(DB::raw("paycat_employe.*, employee.nik, employee.name"))
            ->join("employee","employee.id", "=", "paycat_employe.employee_id", "left")
            ->where("paycat_employe.company_id", $this->company_id)
            ->get();
        $paycat_arr = array();
        foreach ($paycatDB as $key => $value) {            
            foreach ($paycat_employe as $key2 => $value2) {
                if ($value2->paycat_id==$value->id){
                    $paycat_arr[$value->id][] = $value2;  
                    unset($paycat_employe[$key2]);                    
                }
                
            }
        }
        $this->data["paycatDB"] = $paycatDB;
        $this->data["paycat_employe"] = $paycat_arr;        
        return view('paycat.index', $this->data);
    }

    public function getAdd(){                       
        return view('paycat.new', $this->data);
    }

    public function postCreate(){        
        $req = $this->data["req"];
        $validator = Validator::make($req->all(), [            
            'name' => 'required', 
            'formula' => 'required'      
        ]);

        if ($validator->fails()) {            
            return Redirect::to(URL::previous())->withInput(Input::all())->withErrors($validator);                                    
        }

        $arrInsert = $req->input();        

        $existnameDB = DB::table("paycat")->where("name", $arrInsert["name"])->where("company_id", $this->company_id)->first();
        if (isset($existnameDB)){
            return Redirect::to(URL::previous())->withInput(Input::all())->withErrors("name ".$arrInsert["name"]." sudah digunakan");
        }
        
        $arrInsert["created_at"] = date("Y-m-d h:i:s");
        $arrInsert["company_id"] = $this->company_id;
        unset($arrInsert["_token"]);        
        DB::table("paycat")->insert($arrInsert); 
        return redirect('/pcat/list')->with('message', "Successfull create");
    }

    public function getEdit($id){
        $paycat = DB::table("paycat")->where("id", $id)->where("company_id", $this->company_id)->first();                
        $this->data["paycat"] = $paycat;
        return view('paycat.edit', $this->data);        
    }


    public function getEditemployee(){
        $req= $this->data["req"];
        $id = $req->input("id");
        $catid = $req->input("catid");        
        $paycat = DB::table("paycat")->where("company_id", $this->company_id)->where("id", $catid)->first();
        $components = $this->getFormula($paycat);   
        $columns_array = $this->getColumnsFormula();        
        $employ_payroll = DB::table("employee_payroll")->where("company_id", $this->company_id)->where("employee_id", $id)->first();
        $employee = DB::table("employee")->select("nik","name")->where("company_id", $this->company_id)->where("id", $id)->first();
        
        $this->data["payrolls"] = $employ_payroll;
        $this->data["components"] = $components;
        $this->data["paycat"] = $paycat;
        $this->data["employee"] = $employee;
        return view('paycat.editemployee', $this->data);          
    }

    public function getDelete($id){
        $req = $this->data["req"];         
        DB::table("paycat_employe")->where("company_id", $this->company_id)->where("paycat_id", $id)->delete();       
        DB::table("paycat")->where("id", $id)->where("company_id", $this->company_id)->delete();                            
        return redirect('/pcat/list')->with('message', "Successfull delete");
    }

    public function getDeleteemployee($id){
        DB::table("paycat_employe")->where("company_id", $this->company_id)->where("id", $id)->delete();       
        return redirect('/pcat/list')->with('message', "Successfull delete");
    }

    public function getNewemployee(){
        $req= $this->data["req"];
        $req->session()->put("pcat_id", $req->input("id"));
        $employe_ids = DB::table("paycat_employe")->select("employee_id")->where("company_id", $this->company_id)->get();
        $employe_array = array();
        foreach ($employe_ids as $key => $value) {
            $employe_array[] = $value->employee_id;
        }
        $employe = DB::table("employee")->select("nik","name")->where("company_id", $this->company_id)->whereNotIn("id", $employe_array)->get();        
        $this->data["employee"] = $employe;             
        return view('paycat.newemployee', $this->data);
    }

    public function postNewemployee(){
        $req= $this->data["req"];
        $paycat_id = $req->session()->get("pcat_id");
        $name = $req->input("name","-");
        $arrName = explode("-", $name);
        $employee = DB::table("employee")->where("company_id", $this->company_id)->where("nik", trim($arrName[0]))->first();
        $array_insert = array("company_id" => $this->company_id, 
            "paycat_id" => $paycat_id, 
            "employee_id" => $employee->id, 
            "created_at" => date("Y-m-d"));
        DB::table("paycat_employe")->insert($array_insert);
        return redirect('/pcat/list')->with('message', "Successfull create");

    }

    public function _get_index_filter($filter = null){
        $dbcust = DB::table("paycat")->where("company_id", $this->company_id);        
        return $dbcust;
    }

    public function postUpdate($id){
        $req = $this->data["req"];
        $req = $this->data["req"];
        $validator = Validator::make($req->all(), [            
            'name' => 'required', 
            'formula' => 'required'      
        ]);

        if ($validator->fails()) {            
            return Redirect::to(URL::previous())->withInput(Input::all())->withErrors($validator);            
                        
        }
        $arrUpdate = $req->input();        
        unset($arrUpdate["_token"]);        
        DB::table("paycat")->where("id", $id)->update($arrUpdate);        
        return redirect('/pcat/list')->with('message', "Successfull update");
    }

    public function getFormula($paycat){
        $exploded = array();
        if (isset($paycat)){
            $explode_array = array("+","-","/","*",")","(");
            $exploded = $this->data["helper"]->multiexplode($explode_array , $paycat->formula);
        }
        if (isset($exploded)){
            foreach ($exploded as $key => $value) {
                    $exploded[$key] = trim($value);
                }    
        }
        $exploded = array_filter(array_unique($exploded));                
        return $exploded;
    }

    public function getColumnsFormula(){
        $columns = DB::select("SHOW COLUMNS FROM employee_payroll");        
        $columns_array = array();
        foreach ($columns as $key => $value) {
            if ($key>2){
                $columns_array[] = $value->Field;
            }
        }
        return $columns_array;
    }
    
}
    
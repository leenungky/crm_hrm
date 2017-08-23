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
        $this->data["paycatDB"] = $paycatDB;
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

    public function getDelete($id){
        $req = $this->data["req"];         
        DB::table("paycat")->where("id", $id)->where("company_id", $this->company_id)->delete();                    
        return redirect('/pcat/list')->with('message', "Successfull delete");
    }

    public function getNew(){
        $req= $this->data["req"];
        $this->data["parent_id"] = $req->get("id");                
        return view('payroll.new', $this->data);
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

    public function _get_index_filter($filter = null){
        $dbcust = DB::table("paycat")->where("company_id", $this->company_id);        
        return $dbcust;
    }
    
}
    
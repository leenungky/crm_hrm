<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Helpers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use \URL;


class WorkingController extends Controller {
    
    var $data;
    var $company_id;
    public function __construct(Request $req){
    	$this->data["type"]= "master_department";  
        $this->data["req"] = $req;            	
        $this->company_id = \Auth::user()->company_id;
        $this->data["helper"] = new Helpers();
        $this->data["ctrl"] = $this;
    }

	public function getList(){          
        $this->data["type"]= "Working_day";      
        $req = $this->data["req"];      
        $input= $req->input();     
        $dbemploy = $this->_get_index_filter($input);        
        $this->data["employes"] = $dbemploy->get();                                             
        return view('working.index', $this->data);
    }

    public function getTree(){           
        $deptDB = $this->_get_index_filter();                                  
        $deptDB = $deptDB->where("parent_id", 0);    
        $deptDB = $deptDB->get();                
        $this->data["deptDB"] = $deptDB;           
        return view('department.tree', $this->data);
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
        DB::table("department")->insert($arrInsert); 
        if ($id!="root"){
            DB::table("department")->where("id", $id)->update(array("is_group" =>1));       
        }
        return redirect('/department/list')->with('message', "Successfull create");
    }

    public function getEdit($id){
        $customer = DB::table("department")->where("id", $id)->where("company_id", $this->company_id)->first();        
        $this->data["department"] = $customer;
        return view('department.edit', $this->data);        
    }

    public function getDelete($id){
        $req = $this->data["req"]; 
        if ($id=="root"){
            DB::table("department")->where("company_id", $this->company_id)->delete();                
        }else{            
            $department = DB::table("department")->where("company_id", $this->company_id)->where("id", $id)->first();
            $department_child = DB::table("department")
                ->where("company_id", $this->company_id)
                ->where("parent_id", $department->parent_id)
                ->where("id","<>", $id)
                ->get();            
            if (empty($department_child)){                
                DB::table("department")->where("company_id", $this->company_id)->where("id", $department->parent_id)->update(array("is_group"=>0));
            }
            DB::table("department")->where("parent_id", $id)->where("company_id", $this->company_id)->delete();                
            DB::table("department")->where("id", $id)->where("company_id", $this->company_id)->delete();                    
        }        
        return redirect('/department/list')->with('message', "Successfull delete");
    }

    public function getNew(){
        $req= $this->data["req"];
        $this->data["parent_id"] = $req->get("id");                
        return view('department.new', $this->data);
    }

    public function postUpdate($id){
        $req = $this->data["req"];
        $arrInsert = $req->input();        
        unset($arrInsert["_token"]);        
        $customer = DB::table("department")->where("id", $id)->update($arrInsert);        
        return redirect('/department/list')->with('message', "Successfull update");
    }

    private function _get_index_filter($filter){
        $dbemploy = DB::table("employee")->where("employee.company_id", $this->company_id)   
                    ->select(DB::raw("employee.*, department.name as department_name, branch.name as branch_name")) 
                    ->join("department", "department.id", "=", "employee.department_id", "left")
                    ->join("branch", "branch.id", "=", "employee.branch_id", "left");

        if (isset($filter["name"])){
            $dbemploy = $dbemploy->where("employee.name", "like", "%".$filter["name"]."%");
        }
        return $dbemploy;
    }

    
}
    
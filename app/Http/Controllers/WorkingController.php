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
        $req->session()->put("employe_id_working", "");
        $input= $req->input();     
        $dbemploy = $this->_get_index_filter($input);        
        $this->data["employes"] = $dbemploy->get();                                             
        return view('working.index', $this->data);
    }

    
    public function getDetail($id){
        $req = $this->data["req"];
        $req->session()->put("employe_id_working", $id);
        $emp_working = DB::table("employee_working")->where("company_id", $this->company_id)->where("employee_id", $id)->get();        
        $this->data["emp_working"] = $emp_working;        
        return response()->json(array("response"=> array('code' => '200', 'message' => 'Successfull created'), "data"=> array("emp_working" => $this->data["emp_working"])));          
    }

    public function postCreate(){        
        $req = $this->data["req"];
        $validator = Validator::make($req->all(), [                        
            'date' => 'required',
            'type' => 'required'
        ]);

        if ($validator->fails()) {                        
            return response()->json(array("response"=> array('code' => '401', 'message' => $validator->messages()->toJson()), "data"=> array()));  
        }                
        $input = $req->input();
        $employee_id = $req->session()->get("employe_id_working", "");
        if (empty($employee_id)){
            return response()->json(array("response"=> array('code' => '401', 'message' => "Silahkan pilih employee"), "data"=> array()));  
        }
        $emp_working = DB::table("employee_working")
            ->select("id")
            ->where("company_id", $this->company_id)
            ->where("employee_id", $employee_id)
            ->where("date", $input["date"])            
            ->first();        
        $action = "";
        if (isset($emp_working)){
            $emp_working_type = DB::table("employee_working")
            ->select("id")
            ->where("company_id", $this->company_id)
            ->where("employee_id", $employee_id)
            ->where("date", $input["date"])            
            ->where("type", $input["type"])            
            ->first();    
            if (isset($emp_working_type)){                
                $action = "delete";
                $emp_working = DB::table("employee_working")->where("id", $emp_working->id)->delete();    
            }else{
                $action = "update";
                $arr_update = array("date" => $input["date"], "type" => $input["type"]);
                $emp_working = DB::table("employee_working")->where("id", $emp_working->id)->update($arr_update);    
            }             
        }else{
            $action = "insert";
            $arr_insert = array("company_id" => $this->company_id,"employee_id" => $employee_id, "date" => $input["date"], "type" => $input["type"], "created_at" => date("Y-m-d h:i:s"));
            DB::table("employee_working")->insert($arr_insert);
        }
        $this->data["type"] = $input["type"];
        $arr_data = array("type" => $input["type"], "action" => $action);
        return response()->json(array("response"=> array('code' => '200', 'message' => 'Successfull create'), "data"=> $arr_data));  
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
    
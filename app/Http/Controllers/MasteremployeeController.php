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

class MasteremployeeController extends Controller {
    
    var $data;
    var $arrjson;
    var $company_id;
    public function __construct(Request $req){
    	$this->data["type"]= "emplyoee_permition";    	
    	$this->data["req"]= $req;    	
        $this->company_id = \Auth::user()->company_id;
    }

	public function getList(){  
        $this->data["type"]= "emplyoee_list";      
		$req = $this->data["req"];      
        $input= $req->input();     
        $dbemploy = $this->_get_index_filter($input);        
        $this->data["employes"] = $dbemploy->get();
        return view('masteremploy.index', $this->data);
    }

    
   	public function getDetail($id){
		$columns_array = Helpers::getColumnsFormulaMaster();        
        $this->arrjson["columns"] = $columns_array;        
        $master = DB::table("employee_payroll_master")->where("company_id", $this->company_id)->where("employee_id", $id)->first();
        if (isset($master)){
            $master = json_decode(json_encode($master),true);
        }else{
            foreach ($columns_array as $key => $value) {
                $master[$value] = 0;
            }
        }
        $this->arrjson["master"] = $master;
        $this->arrjson["id"] = $id;
		return response()->json(array("response"=> array('code' => '200', 'message' => ''), "data"=> $this->arrjson));  
	}
    
	
	public function postUpdate($id){	
        $req = $this->data["req"];
        $input = $req->input();
        $master = DB::table("employee_payroll_master")->where("company_id", $this->company_id)->where("employee_id", $id)->first();
        unset($input["_token"]);            
        if (isset($master)){
            DB::table("employee_payroll_master")->where("company_id", $this->company_id)->where("employee_id", $id)->update($input);
        }else{
            $input["company_id"] = $this->company_id;
            $input["employee_id"] = $id;
            DB::table("employee_payroll_master")->where("company_id", $this->company_id)->where("employee_id", $id)->insert($input);
        }        
        return redirect('/masteremploy/list')->with('message', "Successfull update");
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
    
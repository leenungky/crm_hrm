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

class PermitionController extends Controller {
    
    var $data;
    var $company_id;
    public function __construct(Request $req){
    	$this->data["type"]= "emplyoee_permition";    	
    	$this->data["req"]= $req;    	
        $this->company_id = \Auth::user()->company_id;
    }

	public function getList(){  
        //  $dbemploy_permition = DB::table("employee_permition")
        // ->select(DB::raw("employee_permition.*, checked.nik as checked_nik, checked.name as checked_name, approved.nik as approved_nik, approved.name as approved_name"))
        // ->join(DB::raw("employee as checked"),DB::raw("checked.id"),"=","employee_permition.checked_by")
        // ->join(DB::raw("employee as approved"),DB::raw("approved.id"),"=","employee_permition.approved_by")
        // ->where("employee_permition.company_id", $this->company_id)
        // ->get();
        // echo "<pre>";
        // print_r($dbemploy_permition);
        // die();

        $this->data["type"]= "emplyoee_list";      
		$req = $this->data["req"];      
        $input= $req->input();     
        $dbemploy = $this->_get_index_filter($input);        
        $this->data["employes"] = $dbemploy->get();
        return view('permition.index', $this->data);
    }

    public function getAdd(){
        $jobtitle = DB::table("jobtitle")->where("company_id", $this->company_id)->get();
        $branch = DB::table("branch")->where("company_id", $this->company_id)->get();
        $family_relation = DB::table("family_relation")->where("company_id", $this->company_id)->get();
        $this->data["jobtitle"] = $jobtitle;
        $this->data["branch"] = $branch;    
        $this->data["family_relation"] = $family_relation;    
		return view('employ.add', $this->data);  
	}

   	public function getDetail($id){
		$employ = DB::table("employee")
            ->where("company_id", $this->company_id)
            ->where("id", $id)->first(); 
        $dbemploy_permition = DB::table("employee_permition")->where("company_id", $this->company_id)->where("employee_id", $id)->get();
        $dbemploy = DB::table("employee")->select("id","nik","name")->where("company_id", $this->company_id)->get();

        $this->data["employes"] = $dbemploy;
        $this->data["dbemploy_permition"] = $dbemploy_permition;
		$this->data["employ"] = $employ;        
		return view('permition.detail', $this->data);  
	}

    public function getDetail1($id){

        $req = $this->data["req"];
        $req->session()->put("id_employe_leave", $id);
        $dbemploy = DB::table("employee")->where("employee.company_id", $this->company_id)->where("employee.id", $id)
                    ->select(DB::raw("employee.*, department.name as department_name, branch.name as branch_name, jobtitle.name as jobtitle_name")) 
                    ->join("department", "department.id", "=", "employee.department_id", "left")
                    ->join("jobtitle", "jobtitle.id", "=", "employee.jobtitle_id", "left")
                    ->join("branch", "branch.id", "=", "employee.branch_id", "left")
                    ->first();        
         $dbemploy_permition = DB::table("employee_permition")
        ->select(DB::raw("employee_permition.*, checked.nik as checked_nik, checked.name as checked_name, approved.nik as approved_nik, approved.name as approved_name"))
        ->join(DB::raw("employee as checked"),DB::raw("checked.id"),"=","employee_permition.checked_by", "left")
        ->join(DB::raw("employee as approved"),DB::raw("approved.id"),"=","employee_permition.approved_by", "left")
        ->where("employee_permition.company_id", $this->company_id)
        ->where("employee_permition.employee_id", $id)->get();        
        

        // $this->data["employes"] = $dbemploy;
        $this->data["dbemploy_permition"] = $dbemploy_permition;
        $this->data["employ"] = $dbemploy;        

        return response()->json(array("response"=> array('code' => '200', 'message' => 'Successfull created'), "data"=> $this->data));  
        // return view('permition.detail', $this->data);  
    }

    public function getDelete($id){
        $employ = DB::table("employee")->where("company_id", $this->company_id)->where("id", $id)->delete();       
        return redirect('/employ/list')->with('message', "Successfull delete");
    }

    public function getFind(){
        $req = $this->data["req"];
        $filter = $req->input("filter","");
        $dbemploy = DB::table("employee")->where("company_id", $this->company_id)
            ->where("name","like", "%".$filter."%")
            ->orWhere("nik","like", "%".$filter."%")
            ->get();        
        $this->data["employ"] = $dbemploy;   

        return response()->json(array("response"=> array('code' => '200', 'message' => 'Successfull created'), "data"=> $this->data));  

    }

	public function postCreate(){	
		$req = $this->data["req"];  
        $family = $req->input("family");
        $arrFamily = json_decode($family);
        $education = $req->input("education");
        $arrEducation = josn_decode($education);         
	 	$validator = Validator::make($req->all(), [            
            'nik' => 'required',
            'name' => 'required',
            'department_id' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        if ($validator->fails()) {                        
            return response()->json(array("response"=> array('code' => '401', 'message' => $validator->messages()->toJson()), "data"=> array()));  
            // return $validator->messages()->toJson();            
        }                
        $arrInsert = $req->input();
        $employee = DB::table("employee")->where("company_id", $this->company_id)->where("nik", $arrInsert["nik"])->first();
        
        if (isset($employee)){
            return response()->json(array("response" => array('code' => '301', 'message' => 'Nik sudah digunakan'), "data"=> array()));            
        }

        $arrInsert["company_id"] = $this->company_id;        
        $arrInsert["created_at"] = date("Y-m-d h:i:s");        

        unset($arrInsert["_token"]);                    
        unset($arrInsert["family"]);
        unset($arrInsert["education"]);                   
        $id = DB::table("employee")->insertGetId($arrInsert);                
        $this->insert_education($id, $arrEducation);
        $this->insert_family($id, $arrFamily);        

        return response()->json(array("response"=> array('code' => '200', 'message' => 'Successfull created'), "data"=> array()));	
	}
	
	public function postUpdate(){	
        $req = $this->data["req"];
        $id = $req->session()->get("id_employe_leave", "");
		$req = $this->data["req"];  
        $permition_leave = $req->input("permition_leave");
        $arrPermitionLeave = json_decode($permition_leave);        
        $validator = Validator::make($req->all(), [            
            'nik' => 'required',
        ]);
 
       if ($validator->fails()) {                        
            return response()->json(array("response"=> array('code' => '401', 'message' => $validator->messages()->toJson()), "data"=> array()));  
        }                
        $arrUpdate = $req->input();        

        $arrUpdate["company_id"] = $this->company_id;
        $arrUpdate["created_at"] = date("Y-m-d h:i:s");
        unset($arrUpdate["permition_leave"]);                
        $this->insert_permition_leave($id, $arrPermitionLeave);        

        return response()->json(array("response"=> array('code' => '200', 'message' => 'Successfull update'), "data"=> array()));  
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

    private function insert_permition_leave($id, $arrPermitionLeave){        
        if (isset($id)){
            $insPermitionLeave = array();
            foreach ($arrPermitionLeave as $key => $value) {
                $insPermitionLeave[$key]["company_id"] = $this->company_id;                
                $insPermitionLeave[$key]["employee_id"] = $id;
                $insPermitionLeave[$key]["propose"] = $value[0];
                $insPermitionLeave[$key]["reason"] =  $value[1];
                $insPermitionLeave[$key]["dari"] = $value[2];
                $insPermitionLeave[$key]["sampai"] = $value[3];
                $insPermitionLeave[$key]["day"] = $value[4];
                $nik = explode("-", $value[5]);                
                $idDB = DB::table("employee")->select("id")->where("company_id", $this->company_id)->where("nik", trim($nik[0]))->first();
                $insPermitionLeave[$key]["checked_by"] =  isset($idDB->id) ? $idDB->id : null;
                $insPermitionLeave[$key]["checked_date"] = $value[6];
                $nik = explode("-", $value[7]);
                $idDB = DB::table("employee")->select("id")->where("company_id", $this->company_id)->where("nik", trim($nik[0]))->first();
                $insPermitionLeave[$key]["approved_by"] = isset($idDB->id) ? $idDB->id : null;
                $insPermitionLeave[$key]["approved_date"] = $value[8];
                $insPermitionLeave[$key]["description"] = $value[9];

            }
            // echo "<pre>";
            // print_r($insPermitionLeave);
            // die();
            DB::table("employee_permition")->where("company_id", $this->company_id)->where("employee_id", $id)->delete();
            if (count($insPermitionLeave)>0){
                DB::table("employee_permition")->insert($insPermitionLeave);
            }
        }
    }

    


}
    
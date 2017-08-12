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

class EmployeeController extends Controller {
    
    var $data;
    var $company_id;
    public function __construct(Request $req){
    	$this->data["type"]= "master_karyawan";    	
    	$this->data["req"]= $req;    	
        $this->company_id = \Auth::user()->company_id;
    }

	public function getList(){  
		$req = $this->data["req"];      
        $input= $req->input();     
        $dbemploy = $this->_get_index_filter($input);        
        $this->data["employes"] = $dbemploy->get();
        return view('employ.index', $this->data);
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

   	public function getEdit($id){
		$employ = DB::table("employee")
            ->select(DB::raw("employee.*, department.id as department_id, department.name as department_name")) 
                    ->join("department", "department.id", "=", "employee.department_id", "left")
            ->where("employee.company_id", $this->company_id)
            ->where("employee.id", $id)->first(); 
        $jobtitle = DB::table("jobtitle")->where("company_id", $this->company_id)->get();
        $branch = DB::table("branch")->where("company_id", $this->company_id)->get();
        $this->data["jobtitle"] = $jobtitle;    
        $this->data["branch"] = $branch;          
		$this->data["employ"] = $employ;
		return view('employ.edit', $this->data);  
	}

    public function getDelete($id){
        $employ = DB::table("employee")->where("company_id", $this->company_id)->where("id", $id)->delete();       
        return redirect('/employ/list')->with('message', "Successfull delete");
    }

	public function postCreate(){	
		$req = $this->data["req"];  
        $family = $req->input("family");
        $arrFamily = json_decode($family);
        $education = $req->input("education");
        $arrEducation = json_decode($education);         
	 	$validator = Validator::make($req->all(), [            
            'nik' => 'required',
            'name' => 'required',
            'department_id' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        if ($validator->fails()) {                        
            return $validator->messages()->toJson();            
        }        
        $arrInsert = $req->input();
        $arrInsert["company_id"] = $this->company_id;        
        $arrInsert["created_at"] = date("Y-m-d h:i:s");        

        unset($arrInsert["_token"]);                    
        unset($arrInsert["family"]);
        unset($arrInsert["education"]);                   
        $id = DB::table("employee")->insertGetId($arrInsert);                
        $this->insert_education($id, $arrEducation);
        $this->insert_family($id, $arrFamily);        

        return response()->json([
            'code' => '200',
            'message' => 'success'
        ]);	
	}
	
	public function postUpdate($id){	
		$req = $this->data["req"];
        $validator = Validator::make($req->all(), [            
            'name' => 'required',
            'department_id' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        if ($validator->fails()) {            
            return Redirect::to(URL::previous())->withInput(Input::all())->withErrors($validator);            
        }
        $arrUpdate = $req->input();
        
        unset($arrUpdate["_token"]); 
        unset($arrUpdate["department"]);               
        DB::table("employee")->where("id", $id)->update($arrUpdate);        
        return redirect('/employ/list')->with('message', "Successfull update");			
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

    private function insert_family($id, $arrFamily){        
        if (isset($id)){
            $insFamily = array();
            foreach ($arrFamily as $key => $value) {
                $insFamily[$key]["company_id"] = $this->company_id;
                $familyDB= DB::table("family_relation")->select("id")->where("name", $value[0])->first();                
                $sex = ($value[4]=="Laki-Laki") ? "L" : "P";                
                $insFamily[$key]["employee_id"] = $id;
                $insFamily[$key]["relation_id"] = $familyDB->id;
                $insFamily[$key]["nama"] = $value[1];
                $insFamily[$key]["birth_place"] = $value[2];
                $insFamily[$key]["birth_date"] = $value[3];
                $insFamily[$key]["sex"] = $sex;
                $insFamily[$key]["education"] = $value[5];
                $insFamily[$key]["description"] = $value[6];
                $insFamily[$key]["created_at"] = date("Y-m-d h:i:s");
            }
            if (count($insFamily)>0){
                DB::table("family")->insert($insFamily);
            }
        }
    }

    private function insert_education($id, $arrEducation){        
        if (isset($id)){
            $insEducation = array();
            foreach ($arrEducation as $key => $value) {
                $insEducation[$key]["company_id"] = $this->company_id;                
                $insEducation[$key]["employee_id"] = $id;
                $insEducation[$key]["nama"] = $value[0];
                $insEducation[$key]["grade"] = $value[1];
                $insEducation[$key]["major_study"] = $value[2];
                $insEducation[$key]["from"] = $value[3];
                $insEducation[$key]["to"] = $value[4];
                $insEducation[$key]["gpa"] = $value[5];
                $insEducation[$key]["description"] = $value[6];
                $insEducation[$key]["created_at"] = date("Y-m-d h:i:s") ;            
            }
            if (count($insEducation)>0){
                DB::table("education")->insert($insEducation);
            }
        }
    }


}
    
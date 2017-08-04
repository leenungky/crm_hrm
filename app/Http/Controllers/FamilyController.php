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

class FamilyController extends Controller {
    
    var $data;
    var $company_id;
    public function __construct(Request $req){
    	$this->data["type"]= "master_family_relation";    	
    	$this->data["req"]= $req;
        $this->company_id = \Auth::user()->company_id;    	
    }

	public function getList(){  
		$req = $this->data["req"];      
        $input= $req->input();     
        $familydb = $this->_get_index_filter($input);
        $this->data["family"] = $familydb->get();
        return view('family.index', $this->data);
    }

    public function getAdd(){                
		return view('family.new', $this->data);  
	}

	public function getEdit($id){
		$family = DB::table("family_relation")->where("id", $id)->where("company_id", $this->company_id)->first();                
		$this->data["family"] = $family;
		return view('family.edit', $this->data); 
	}

	public function postCreate(){	
		$req = $this->data["req"];
	 	$validator = Validator::make($req->all(), [            
            'name' => 'required',           
        ]);

        if ($validator->fails()) {            
            return Redirect::to(URL::previous())->withInput(Input::all())->withErrors($validator);            
        }        
        $arrInsert = $req->input();        
        $arrInsert["created_at"] = date("Y-m-d h:i:s");        
        $arrInsert["company_id"] = $this->company_id;
        unset($arrInsert["_token"]);        
        DB::table("family_relation")->insert($arrInsert);        
        return redirect('/family/list')->with('message', "Successfull create");			
	}

    public function getDelete(Request $req, $id){       
        $user = DB::table("family_relation")->where("id" , $id)->where("company_id" , $this->company_id)->delete();
        return redirect('/family/list')->with('message', "Successfull delete");
    }

    	
	public function postUpdate($id){	
        $req = $this->data["req"];
		$validator = Validator::make($req->all(), [            
            'name' => 'required'
        ]);

        if ($validator->fails()) {            
            return Redirect::to(URL::previous())->withInput(Input::all())->withErrors($validator);            
        }
        $arrUpdate = $req->input();        
        unset($arrUpdate["_token"]);        
        DB::table("family_relation")->where("id", $id)->where("company_id", $this->company_id)->update($arrUpdate);        
        return redirect('/family/list')->with('message', "Successfull update");			
	}

	private function _get_index_filter($filter){
        $dbcust = DB::table("family_relation")
            ->where("company_id", $this->company_id );
        if (isset($filter["name"])){
            $dbcust = $dbcust->where("name", "like", "%".$filter["name"]."%");
        }        
        return $dbcust;
    }

}
    
<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Helpers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class EducationController extends Controller {
    
    var $data;
    var $company_id;
    public function __construct(Request $req){
    	$this->data["type"]= "Pendidikan";        
        $this->data["req"] = $req;   
        $this->company_id = \Auth::user()->company_id;
    }

	 public function getList(){
        $req = $this->data["req"];
        $input = $req->input();        
        $eduDB = $this->_get_index_filter($input);              
        $eduDB = $eduDB->paginate(20); 
        $this->data["education"] = $eduDB;
        $this->data["filter"] = $input;        
        return view('education.index', $this->data);
    }

    public function getNew(){
        return view('education.new', $this->data);
    }

    public function getEdit($id){
        $req = $this->data["req"];
        $price = DB::table("education_relation")->where("id", $id)->where("company_id", $this->company_id)->first();
        $this->data["education"] = $price;
        return view('education.edit', $this->data);
    }

    public function getDelete($id){        
        $req = $this->data["req"];
        DB::table("education")->where("id", $id)->where("company_id", $this->company_id)->delete();        
        return redirect('/education/list')->with('message', "Successfull delete");    
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
        DB::table("education_relation")->insert($arrInsert);        
        return redirect('/education/list')->with('message', "Successfull create");         
    }

    public function postUpdate($id){
        $req = $this->data["req"];
        $validator = Validator::make($req->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {            
            return Redirect::to(URL::previous())->withInput(Input::all())->withErrors($validator);            
        }    
        
        $arrInsert = $req->input();        
        unset($arrInsert["_token"]);        
        DB::table("education_relation")->where("id", $id)->where("company_id", $this->company_id)->update($arrInsert);        
        return redirect('/education/list')->with('message', "Successfull update");
    }

    private function _get_index_filter($filter){                
        $req = $this->data["req"];
        $eduDB = DB::table("education_relation")->where("company_id", $this->company_id);    
        if (isset($filter["name"])){
            $eduDB = $eduDB->where("name", "like", "%".$filter["name"]."%");
        }         
        $eduDB = $eduDB->orderBy("id", "desc");
        return $eduDB;
    }

    private function _get_index_sort($req, $transDB, $input){                        
        
    }

     
}
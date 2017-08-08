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

class DepartmentController extends Controller {
    
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
        return view('department.index', $this->data);
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
        DB::table("department")->where("parent_id", $id)->where("company_id", $this->company_id)->delete();                
        DB::table("department")->where("id", $id)->where("company_id", $this->company_id)->delete();                
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

    public function _get_index_filter($filter = null){
        $dbcust = DB::table("department")->where("company_id", $this->company_id);
        if (isset($filter["name"])){
            $dbcust = $dbcust->where("name", "like", "%".$filter["name"]."%");
        }       
        return $dbcust;
    }

    private function _get_index_sort($req, $custDB, $input){                        
        if (isset($input["sort"])){
            if (empty($input["order_by"])){
                $order_by = "asc";       
            }else{
                $order_by = $input["order_by"];
            }
            $this->data["order_by"] = $order_by; 
            $this->data["sort"] = $input["sort"];

            if ($input["sort"]=="nama"){
                if ($order_by == "asc"){
                    $this->data["arrow_nama"] = '<span class="glyphicon glyphicon-menu-down"></span>';
                }elseif ($order_by == "desc"){
                    $this->data["arrow_nama"] = '<span class="glyphicon glyphicon-menu-up"></span>';
                }      
                $custDB = $custDB->orderBy("name", $order_by);                                
            }
            else if ($input["sort"]=="owner"){
                if ($order_by == "asc"){
                    $this->data["arrow_owner"] = '<span class="glyphicon glyphicon-menu-down"></span>';
                }elseif ($order_by == "desc"){
                    $this->data["arrow_owner"] = '<span class="glyphicon glyphicon-menu-up"></span>';
                }      
                $custDB = $custDB->orderBy("owner", $order_by);                                
            }
            else if ($input["sort"]=="email"){
                if ($order_by == "asc"){
                    $this->data["arrow_email"] = '<span class="glyphicon glyphicon-menu-down"></span>';
                }elseif ($order_by == "desc"){
                    $this->data["arrow_email"] = '<span class="glyphicon glyphicon-menu-up"></span>';
                }      
                $custDB = $custDB->orderBy("email", $order_by);                                
            }
            else if ($input["sort"]=="discount"){
                if ($order_by == "asc"){
                    $this->data["arrow_discount"] = '<span class="glyphicon glyphicon-menu-down"></span>';
                }elseif ($order_by == "desc"){
                    $this->data["arrow_discount"] = '<span class="glyphicon glyphicon-menu-up"></span>';
                }      
                $custDB = $custDB->orderBy("discount", $order_by);                                
            }
            else if ($input["sort"]=="phone"){
                if ($order_by == "asc"){
                    $this->data["arrow_phone"] = '<span class="glyphicon glyphicon-menu-down"></span>';
                }elseif ($order_by == "desc"){
                    $this->data["arrow_phone"] = '<span class="glyphicon glyphicon-menu-up"></span>';
                }      
                $custDB = $custDB->orderBy("phone", $order_by);                                
            }
            else if ($input["sort"]=="address"){
                if ($order_by == "asc"){
                    $this->data["arrow_address"] = '<span class="glyphicon glyphicon-menu-down"></span>';
                }elseif ($order_by == "desc"){
                    $this->data["arrow_address"] = '<span class="glyphicon glyphicon-menu-up"></span>';
                }      
                $custDB = $custDB->orderBy("address", $order_by);                                
            }
            else if ($input["sort"]=="created"){
                if ($order_by == "asc"){
                    $this->data["arrow_created"] = '<span class="glyphicon glyphicon-menu-down"></span>';
                }elseif ($order_by == "desc"){
                    $this->data["arrow_created"] = '<span class="glyphicon glyphicon-menu-up"></span>';
                }      
                $custDB = $custDB->orderBy("created_at", $order_by);                                
            }
        }else{
            $custDB = $custDB->orderBy("id", "desc");
        }        
                           
        return $custDB;
    }

}
    
<?php namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Helpers;
use App\lib\Field_calculate;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use \URL;


class PayrollemployeeController extends Controller {
    
    var $data;
    var $company_id;
    var $month = array("01" => "January", "02" => "February", "03" => "March", "04" => "April", "05" => "May", "06" => "June", "07" => "July", "08" => "August", "09" => "September", "10" => "October", "11" => "November", "12" => "December");
    public function __construct(Request $req){
        $this->data["type"]= "master_payroll";  
        $this->data["req"] = $req;              
        $this->company_id = \Auth::user()->company_id;
        $this->data["helper"] = new Helpers();
        $this->data["ctrl"] = $this;
    }

    public function getList(){                                               
        $req = $this->data["req"];
        $input = $req->input();
        $columns = $this->getColumnsFormula();        
        $arr_columns = array();
        foreach ($columns as $key => $value) {
            $arr_columns[]= "employee_payroll.".$value;            
        }        
        $str_columns =join(',', $arr_columns);           

        $req->session()->forget('month_payroll');
        $req->session()->forget('year_payroll');


        $payroll_emp = DB::table("employee")
            ->select(DB::raw("employee.id as emp_id, employee.nik, employee.name,".$str_columns))
            ->join("employee_payroll","employee_payroll.employee_id", "=", "employee.id", "left")
            ->where("employee.company_id", $this->company_id)
            ->get();        
        $employee_paycat = DB::table("paycat_employe")
            ->select("paycat_employe.employee_id", "paycat.formula")
            ->join("paycat", "paycat.id", "=", "paycat_employe.paycat_id", "left")
            ->get();
        $employee_paycat_array = array();
        foreach ($employee_paycat as $key => $value) {
            $employee_paycat_array[$value->employee_id] = $value->formula;
        }
        
        $cal = new Field_calculate();
        $result = $cal->calculate('(5+9)*5'); // 70
        print_r($employee_paycat_array);
        print_r($result);
        die();
        $this->data["cal"] = new Field_calculate();    

    
        
        $payroll_emp = json_decode(json_encode($payroll_emp),true);
        $this->data["payroll_emp"] = $payroll_emp;        
        $this->data["columns"] = $columns;                
        $this->data["payroll_cat"] = $employee_paycat_array;
        $this->data["year"] = array("from" => (date("Y")-10), "to" => date("Y"));        
        $this->data["month"] = $this->month;
        $this->data["input"] = $input;             ;        
        return view('payroll_employ.index', $this->data);
    }

    public function getEditemployee($id){
        $req= $this->data["req"];                
        $input = $req->input();
        $month = isset($input["month"])?  $input["month"] : date("m");
        $year = isset($input["year"])?  $input["year"] : date("Y");        

        $req->session()->put("month_payroll", $month);
        $req->session()->put("year_payroll", $year);

        $paycat = DB::table("paycat_employe")
            ->select("paycat.formula")
            ->join("paycat", "paycat.id", "=","paycat_employe.paycat_id", "left")
            ->where("paycat_employe.company_id", $this->company_id)
            ->where("paycat_employe.employee_id", $id)
            ->first();
             

        $components = $this->getFormula($paycat);   
        $columns_array = Helpers::getColumnsFormula();        
        
        $employ_payroll = DB::table("employee_payroll")->where("company_id", $this->company_id)->where("employee_id", $id);        
        $employ_payroll = $employ_payroll->where("month", $month);
        $employ_payroll = $employ_payroll->where("year", $year);
        $employ_payroll = $employ_payroll->first();

        $employ_payroll = json_decode(json_encode($employ_payroll),true);        

        $employee = DB::table("employee")->select("id","nik","name")->where("company_id", $this->company_id)->where("id", $id)->first();
        
        $this->data["employ_payroll"] = $employ_payroll;
        $this->data["components"] = $components;
        $this->data["paycat"] = $paycat;
        $this->data["employee"] = $employee;
        $title = "master_payroll";
        
        $this->data["type"] = "master_payroll - " .$this->month[$month]." ".$year;
        
        return view('payroll_employ.editemployee', $this->data);          
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
        $arrUpdate = $req->input();        
        $month = $req->session()->get("month_payroll","");
        $year = $req->session()->get("year_payroll", "");
        if (empty($month) || empty($year)){
            return Redirect::to(URL::previous())->withInput(Input::all())->withErrors("Tahun atau bulan tidak boleh kosong");    
        }

        $emp_payrollDB = DB::table("employee_payroll")
            ->where("company_id", $this->company_id)
            ->where("employee_id", $id)
            ->where("year", $year)
            ->where("month", $month);
        $emp_payroll_first = $emp_payrollDB->first();

        unset($arrUpdate["_token"]);       
        if (isset($emp_payroll_first)){
            $emp_payrollDB->update($arrUpdate);
        }else{
            $arrUpdate["employee_id"] = $id;
            $arrUpdate["year"] = $year;
            $arrUpdate["month"] = $month;
            $arrUpdate["company_id"] = $this->company_id;            
            $emp_payrollDB->insert($arrUpdate);
        }
        
        return redirect('/payrollemploy/list')->with('message', "Successfull update");
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

    // public function getColumnsFormula(){
    //     $columns = DB::select("SHOW COLUMNS FROM employee_payroll");        
    //     $columns_array = array();
    //     foreach ($columns as $key => $value) {
    //         if ($key>6){
    //             $columns_array[] = $value->Field;
    //         }
    //     }
    //     return $columns_array;
    // }

    public function getDate(){

    }
    
}
    
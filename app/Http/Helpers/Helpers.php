<?php
	namespace App\Http\Helpers;		
	use \Session; 
	use App\Http\Helpers\WebCurl;
	use App\Http\Helpers\Api;
	use Illuminate\Support\Facades\DB;

	class Helpers{		

		public function getDbTreeDepartment($ctrl, $value){
			if ($value->is_group==1){
                $deptGroupDB = $ctrl->_get_index_filter();   
                $deptGroupDB = $deptGroupDB->where("parent_id", $value->id);
                $deptGroupDB = $deptGroupDB->get();
                $value->child = $deptGroupDB;                              
                echo "<ul>";
                foreach ($deptGroupDB as $keychild => $valuechild) {                    	
                	echo "<li><a href='javascript:void(0)' id='".$valuechild->id."' class='right-click'>".$valuechild->name."</a>";
                	$this->getDbTreeDepartment($ctrl, $valuechild);
                	echo "</li>";
                }   
                echo "</ul>";                             
            }
            return $value;
		}
		public function multiexplode ($delimiters,$string) {

		    $ready = str_replace($delimiters, $delimiters[0], $string);
		    $launch = explode($delimiters[0], $ready);
		    return  $launch;
		}		

		public static function getColumnsFormula(){
	        $columns = DB::select("SHOW COLUMNS FROM employee_payroll");        
	        $columns_array = array();
	        foreach ($columns as $key => $value) {
	            if ($key>6){
	                $columns_array[] = $value->Field;
	            }
	        }
	        return $columns_array;
	    }

	    public static function getColumnsFormulaMaster(){
	        $columns = DB::select("SHOW COLUMNS FROM employee_payroll_master");             
	        $columns_array = array();
	        foreach ($columns as $key => $value) {
	            if ($key>2){
	                $columns_array[] = $value->Field;
	            }
	        }
	        return $columns_array;
	    }
	}
?>
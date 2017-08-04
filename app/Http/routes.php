<?php



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
// */
Route::get('/', [
    'as' => 'index', 'uses' => 'UserController@getLogin'
]);


// Route::get('/signin', [
//     'as' => 'signin', 'uses' => 'InventoryController@signin'
// ]);


Route::group(['middleware' => 'logic'], function(){
	Route::controller('/user', 'UserController');
	Route::controller('/role', 'RoleController');
	Route::controller('/department', 'DepartmentController');
	Route::controller('/jobtitle', 'JobtitleController');
	Route::controller('/family', 'FamilyController');		
	Route::controller('/cuti', 'CutiController');	
	Route::controller('/education', 'EducationController');	
	Route::controller('/employ', 'EmployeeController');		
	Route::controller('/branch', 'BranchController');		
	
	
});

Route::group(['prefix' => 'auth'], function(){
	Route::auth();
});


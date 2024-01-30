<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RoleController;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function(){

});

//Auth
Route::controller(AuthController::class)->group(function(){
    Route::post('user/login', 'login');
    Route::post('user/change/password/{id}', 'changePassword');
});

//Employee data
Route::controller(EmployeeController::class)->group(function(){
    Route::get('employeeList', 'getEmployeeList');
    Route::get('employee/formData', 'getEmployeeFormData');
    Route::post('employee/create', 'createEmployee');
    Route::get('employee/userData/{id}', 'getUserData');
    Route::post('employee/update', 'updateEmployee');
    Route::get('employee/delete/{id}', 'deleteEmployee');
});


//department
Route::controller(DepartmentController::class)->group(function(){
    Route::get('departmentList', 'getDepartmentList');
    Route::post('department/create', 'createDepartment');
    Route::get('department/update/{id}', 'getData');
    Route::post('department/update', 'updateDepartment');
    Route::get('department/delete/{id}', 'deleteDepartment');
});


//role
Route::controller(RoleController::class)->group(function(){
    Route::get('roleList', 'getRoleList');
    Route::post('role/create', 'createRole');
    Route::get('role/update/{id}', 'getData');
    Route::post('role/update', 'updateRole');
    Route::get('role/delete/{id}', 'deleteRole');
});

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckinCheckoutController;
use App\Http\Controllers\CompanysettingController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalaryController;
use App\Models\Department;
use App\Models\Salary;
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

//company
Route::controller(CompanysettingController::class)->group(function(){
    Route::get('company/data', 'getCompanyData');
    Route::post('company/update', 'updateCompany');
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


//checkin/checkout and attendance crud
Route::controller(CheckinCheckoutController::class)->group(function(){
    Route::post('checkInOut', 'check');
    Route::get('checkInOutData/{id}', 'checkattend');
    Route::get('attendanceList', 'getAttendance');
    Route::get('attendanceList/user/{id}', 'getUserAttendance');
    Route::get('attendance/data', 'getDataforCreatePage');
    Route::post('attendance/create', 'createAttendance');
    Route::get('attendance/update/{id}', 'getData');
    Route::post('attendance/update', 'updateAttendance');
    Route::get('attendance/delete/{id}', 'deleteAttendance');
    Route::get('attendance/overview/{month}/{year}', 'attendanceOverview');

});

//salary
Route::controller(SalaryController::class)->group(function(){
    Route::get('salaryList', 'getSalaryList');
    Route::get('salary/getFormData', 'getFormData');
    Route::post('salary/create', 'createSalary');
    Route::get('salary/update/{id}', 'getData');
    Route::post('salary/update', 'updateSalary');
    Route::get('salary/delete/{id}', 'deleteSalary');
});

//Payroll
Route::get('payroll/{month}/{year}',[ PayrollController::class, 'getPayroll']);

//get each records data
Route::get('records/{month}/{year}/{id}', [RecordController::class, 'getRecords']);

//projects
Route::controller(ProjectController::class)->group(function(){
    Route::get('projectList', 'getProjectList');
    Route::post('project/create', 'createProject');
    Route::get('project/update/{id}', 'getProjectData');
});

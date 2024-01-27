<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
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
    Route::post('user/register', 'register');
    Route::post('user/login', 'login');
});

//Employee data
Route::controller(EmployeeController::class)->group(function(){
    Route::post('employeeList', 'getEmployeeList');
    Route::get('employee/formData', 'getEmployeeFormData');
    Route::post('employee/create', 'createEmployee');
    Route::get('employee/userData/{id}', 'getUserData');
    Route::post('employee/update', 'updateEmployee');
    Route::get('employee/delete/{id}', 'deleteEmployee');
});


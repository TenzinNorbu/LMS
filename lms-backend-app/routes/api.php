<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SecurityModule\LoginController;
use App\Http\Controllers\SecurityModule\RoleController;
use App\Http\Controllers\SecurityModule\UserController;
use App\Http\Controllers\SecurityModule\ProfileController;
use App\Http\Controllers\SecurityModule\ChangeAndForgotPasswordController;
use App\Http\Controllers\MasterData\BranchController;
use App\Http\Controllers\MasterData\DepartmentController;
use App\Http\Controllers\ApplicantModule\ApplicantInfoController;
use App\Http\Controllers\ApplicantModule\LoanDetailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/user-registration', [UserController::class, 'store']);
Route::post('/forgot-password', [ChangeAndForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('/reset-password', [ChangeAndForgotPasswordController::class, 'passwordReset']);


Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => 'auth'
], function ($router) { 
    Route::get('/user-lists', [UserController::class, 'index']);
    Route::get('/user-show/{id}', [UserController::class, 'show']);
    Route::post('/user-update/{id}', [UserController::class, 'update']);
    Route::post('/user-delete/{id}', [UserController::class, 'destroy']);
    Route::post('/refresh-token', [LoginController::class, 'refreshToken']);
    Route::post('/logout', [LoginController::class, 'logout']);

//role
    Route::post('/role-create', [RoleController::class, 'store']);
    Route::get('/role-lists', [RoleController::class, 'index']);
    Route::get('/role-show/{id}', [RoleController::class, 'show']);
    Route::post('/role-update/{id}', [RoleController::class, 'update']);
    Route::post('/role-delete/{id}', [RoleController::class, 'destroy']);  
    
    Route::post('/change-password/{id}', [ChangeAndForgotPasswordController::class, 'updatePassword']);
});

Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => 'branch'
], function ($router) {
    Route::post('/create', [BranchController::class, 'store']);
    Route::get('/lists', [BranchController::class, 'index']);
    Route::get('/show/{id}', [BranchController::class, 'show']);
    Route::post('/update/{id}', [BranchController::class, 'update']);
    Route::post('/delete/{id}', [BranchController::class, 'destroy']);

});
Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => 'department'
], function ($router) {
    Route::post('/create', [DepartmentController::class, 'store']);
    Route::get('/lists', [DepartmentController::class, 'index']);
    Route::get('/show/{id}', [DepartmentController::class, 'show']);
    Route::post('/update/{id}', [DepartmentController::class, 'update']);
    Route::post('/delete/{id}', [DepartmentController::class, 'destroy']);

});
Route::group([
    'middleware' => 'api',
    'prefix' => 'profile'
], function ($router) {
    Route::post('/update/{id}', [ProfileController::class, 'profile']);
   
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'applicant'
], function ($router) {
    Route::post('/create', [ApplicantInfoController::class, 'store']);
    Route::get('/lists', [ApplicantInfoController::class, 'index']);
    Route::get('/show/{id}', [ApplicantInfoController::class, 'show']);
    Route::post('/update/{id}', [ApplicantInfoController::class, 'update']);
    Route::post('/delete/{id}', [ApplicantInfoController::class, 'destroy']);

});

Route::group([
    'middleware' => 'api',
    'prefix' => 'loan'
], function ($router) {
    Route::post('/apply', [LoanDetailController::class, 'store']);
    Route::get('/lists', [ApplicantInfoController::class, 'index']);
    Route::get('/show/{id}', [ApplicantInfoController::class, 'show']);
    Route::post('/update/{id}', [ApplicantInfoController::class, 'update']);
    Route::post('/delete/{id}', [ApplicantInfoController::class, 'destroy']);

});
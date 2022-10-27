<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserManagementModule\LoginLogoutController;
use App\Http\Controllers\UserManagementModule\UserController;
use App\Http\Controllers\UserManagementModule\RoleController;
use App\Http\Controllers\UserManagementModule\PermissionController;
use App\Http\Controllers\UserManagementModule\ProfileController;
use App\Http\Controllers\UserManagementModule\ChangeForgotPasswordController;
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

Route::post('/login', [LoginLogoutController::class, 'authenticate']);
Route::post('/register', [UserController::class, 'store']);
Route::post('/forgot-password', [ChangeForgotPasswordController::class, 'resetEmailLink']);
Route::post('/reset-password/{token}', [ChangeForgotPasswordController::class, 'passwordResetLink']);


Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => 'auth'
], function ($router) { 
//user
    Route::resource('user', UserController::class);
    Route::post('/refresh-token', [LoginLogoutController::class, 'refreshToken']);
    Route::post('/logout', [LoginLogoutController::class, 'logout']);
    Route::post('/change-password/{id}', [ChangeForgotPasswordController::class, 'changePassword']);
//role & permission
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);

    // Route::post('/role-create', [RoleController::class, 'store']);
    // Route::get('/role-lists', [RoleController::class, 'index']);
    // Route::get('/role-show/{id}', [RoleController::class, 'show']);
    // Route::post('/role-update/{id}', [RoleController::class, 'update']);
    // Route::post('/role-delete/{id}', [RoleController::class, 'destroy']);  
    
});

Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => 'master-data'
], function ($router) {
    Route::resource('branch', BranchController::class);
    Route::resource('department', DepartmentController::class);
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
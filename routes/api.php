<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\VerificationController;




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

Route::group(['middleware' => 'guest'], function (){
    Route::post('register',[AuthController::class, 'register']);
    Route::post('login',[AuthController::class, 'login']);

    Route::post('forgot-password', [PasswordResetLinkController::class, 'sendEmail'])->name('password.email');
    Route::post('reset-password', [NewPasswordController::class, 'resetPassword'])->name('password.reset');

});

Route::group(['middleware' => 'auth'], function () {

    Route::apiResource('projects',ProjectController::class);
    Route::apiResource('users',UserController::class);
    Route::apiResource('clients',ClientController::class);
    Route::apiResource('tasks',TaskController::class);
    Route::apiResource('roles', RoleController::class);

    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user-profile', [AuthController::class, 'userProfile'])->name('user-profile');
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('user/add-avatar', [UserController::class, 'Addavatar']);
    Route::post('user/update-password', [UserController::class, 'updatePassword']);


    Route::get('email/verify/{id}', [VerificationController::class,'verify'])->name('verification.verify'); // Make sure to keep this as your route name
    Route::get('email/resend', [VerificationController::class,'resend'])->name('verification.resend');
 
});





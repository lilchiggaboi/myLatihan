<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;

Route::get('/', function () {
    return view('auth/login');
});

Route::get('login', [AuthController::class, 'index']);
Route::post('login', [AuthController::class, 'AuthenticateLogin']);

Route::get('register', [AuthController::class, 'index_register']);
Route::post('register', [AuthController::class, 'RegisterSave']);
Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verify.email');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/reset-password', [ResetPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('logout', [AuthController::class, 'logout']);

Route::get('user', [DashboardUserController::class, 'index']);
Route::get('edit_profile', [DashboardUserController::class, 'editProfile']);
Route::post('edit_profile', [DashboardUserController::class, 'store'])->name('user.store');

Route::group(['middlewaree' => ['CheckSession:1'], 'prefix' => 'admin'], function () {

    Route::get('dosen', [DosenController::class, 'index']);
    Route::post('save-dosen', [DosenController::class, 'save_dosen']);
    Route::post('edit-dosen', [DosenController::class, 'edit_dosen']);
    Route::get('delete-dosen/{id}', [DosenController::class, 'delete_dosen']);
    Route::post('delete-selected-dosen', [DosenController::class, 'deleteSelectedDosen']);

    Route::get('user', [UserController::class, 'index']);
    Route::post('save-user', [UserController::class, 'save_user']);
    Route::post('edit-user', [UserController::class, 'edit_user']);
    Route::get('delete-user/{id}', [UserController::class, 'delete_user']);
});
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\EquipmentListController;
use App\Http\Controllers\EquipmentCategoryController;
use App\Http\Controllers\EquipmentItemController;
use App\Http\Controllers\PointController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('/dang-nhap', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/dang-nhap', [AuthController::class, 'login'])->name('login.submit');
Route::post('/dang-xuat', [AuthController::class, 'logout'])->name('logout');

// resert password
Route::get('/quen-mat-khau', [ForgotPasswordController::class, 'showForm'])->name('forgot-password.form');
Route::post('/quen-mat-khau', [ForgotPasswordController::class, 'sendRequest'])->name('forgot-password.send');

// Cách 1: Đặt tên đúng cho route
Route::prefix('admin')->group(function () {
    Route::get('/password-requests', [ForgotPasswordController::class, 'index'])->name('password-requests.index');
    Route::get('/password-requests/{id}/reset', [ForgotPasswordController::class, 'resetForm'])->name('password-requests.reset');
    Route::post('/password-requests/{id}/reset', [ForgotPasswordController::class, 'resetPassword'])->name('password-requests.reset.submit');
});

 //model    
Route::get('/trang-chu', [HomeController::class, 'index'])->name('home');
Route::resource('branches', BranchController::class);
Route::resource('departments', DepartmentController::class);
Route::resource('equipment-lists', EquipmentListController::class);
Route::resource('equipment-categories', EquipmentCategoryController::class);
Route::resource('equipment-items', EquipmentItemController::class);
Route::resource('points', PointController::class);

// Tạo tài khoản
Route::resource('admins', AdminController::class);

// Redirect mặc định
Route::get('/', function () {
    return redirect()->route('login');
});
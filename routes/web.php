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
use App\Http\Controllers\AdminApprovalController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/dang-nhap', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/dang-nhap', [AuthController::class, 'login'])->name('login.submit');
Route::post('/dang-xuat', [AuthController::class, 'logout'])->name('logout');
Route::get('/quen-mat-khau', [ForgotPasswordController::class, 'showForm'])->name('forgot-password.form');
Route::post('/quen-mat-khau', [ForgotPasswordController::class, 'sendRequest'])->name('forgot-password.send');
Route::prefix('admin')->group(function () {
    Route::get('/password-requests', [ForgotPasswordController::class, 'index'])->name('password-requests.index');
    Route::get('/password-requests/{id}/reset', [ForgotPasswordController::class, 'resetForm'])->name('password-requests.reset');
    Route::post('/password-requests/{id}/reset', [ForgotPasswordController::class, 'resetPassword'])->name('password-requests.reset.submit');
    Route::delete('/password-requests/{id}', [ForgotPasswordController::class, 'destroy'])
    ->name('password-requests.destroy');});
Route::get('/trang-chu', [DashboardController::class, 'index'])->name('home');
Route::resource('branches', BranchController::class);
Route::resource('departments', DepartmentController::class);
Route::resource('equipment-lists', EquipmentListController::class);
Route::resource('equipment-categories', EquipmentCategoryController::class);
Route::resource('equipment-items', EquipmentItemController::class)->except(['show']);
Route::get('/equipment-items/export-excel', [EquipmentItemController::class, 'exportExcel'])->name('equipment-items.export');
Route::resource('points', PointController::class);
Route::prefix('admin')->middleware('admin.session')->group(function () {
    Route::get('/pending', [AdminApprovalController::class, 'index'])->name('admin.pending.index');
    Route::get('/pending/list/{id}', [AdminApprovalController::class, 'showList'])->name('admin.pending.show-list');
    Route::get('/pending/category/{id}', [AdminApprovalController::class, 'showCategory'])->name('admin.pending.show-category');
    Route::get('/pending/item/{id}', [AdminApprovalController::class, 'showItem'])->name('admin.pending.show-item');
    Route::post('/pending/list/{id}/approve', [AdminApprovalController::class, 'approveList'])->name('admin.pending.approve-list');
    Route::post('/pending/category/{id}/approve', [AdminApprovalController::class, 'approveCategory'])->name('admin.pending.approve-category');
    Route::post('/pending/item/{id}/approve', [AdminApprovalController::class, 'approveItem'])->name('admin.pending.approve-item');
    Route::post('/pending/list/{id}/reject', [AdminApprovalController::class, 'rejectList'])->name('admin.pending.reject-list');
    Route::post('/pending/category/{id}/reject', [AdminApprovalController::class, 'rejectCategory'])->name('admin.pending.reject-category');
    Route::post('/pending/item/{id}/reject', [AdminApprovalController::class, 'rejectItem'])->name('admin.pending.reject-item');});
Route::get('/thong-bao', [NotificationController::class, 'index'])->name('notifications.index');
Route::delete('/thong-bao/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
Route::resource('admins', AdminController::class);
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/dashboard/broken', [DashboardController::class, 'getBrokenEquipment'])->name('dashboard.broken');



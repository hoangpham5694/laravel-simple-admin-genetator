<?php

use Illuminate\Support\Facades\Route;
use HoangPhamDev\SimpleAdminGenerator\Http\Controllers\AuthController;
use HoangPhamDev\SimpleAdminGenerator\Http\Controllers\AdminController;

Route::get('/login', [AuthController::class, 'index'])->name('simple_admin_generation.index');
Route::post('/login', [AuthController::class, 'login'])->name('simple_admin_generation.login');
Route::middleware(['admin'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('simple_admin_generation.logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('simple_admin_generation.profile');

    Route::get('/admins', [AdminController::class, 'index'])->name('simple_admin_generation.admin.index');
    Route::get('/admins/edit/{id}', [AdminController::class, 'edit'])->name('simple_admin_generation.admin.edit');
    Route::get('/admins/detail/{id}', [AdminController::class, 'detail'])->name('simple_admin_generation.admin.detail');
    Route::post('/admins/edit/{id}', [AdminController::class, 'update'])->name('simple_admin_generation.admin.update');
    Route::post('/admins/update-password/{id}', [AdminController::class, 'update_password'])->name('simple_admin_generation.admin.update_password');
    Route::post('/admins/destroy', [AdminController::class, 'destroy'])->name('simple_admin_generation.admin.destroy');

});
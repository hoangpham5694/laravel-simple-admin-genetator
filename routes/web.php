<?php

use Illuminate\Support\Facades\Route;
use HoangPhamDev\SimpleAdminGenerator\Http\Controllers\AuthController;
use HoangPhamDev\SimpleAdminGenerator\Http\Controllers\AdminController;

Route::get('/login', [AuthController::class, 'index'])->name('sag.index');
Route::post('/login', [AuthController::class, 'login'])->name('sag.login');
Route::middleware(['admin'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('sag.logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('sag.profile');

    Route::get('/admins', [AdminController::class, 'index'])->name('sag.admin.index');
    Route::get('/admins/edit/{id}', [AdminController::class, 'edit'])->name('sag.admin.edit');
    Route::get('/admins/detail/{id}', [AdminController::class, 'detail'])->name('sag.admin.detail');
    Route::post('/admins/edit/{id}', [AdminController::class, 'update'])->name('sag.admin.update');
    Route::get('/admins/create', [AdminController::class, 'create'])->name('sag.admin.create');
    Route::post('/admins/store', [AdminController::class, 'store'])->name('sag.admin.store');
    Route::post('/admins/update-password/{id}', [AdminController::class, 'updatePassword'])->name('sag.admin.update_password');
    Route::post('/admins/destroy', [AdminController::class, 'destroy'])->name('sag.admin.destroy');
});

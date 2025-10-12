<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', [HomeController::class, 'index']) ->name('index');
Route::get('/create', [HomeController::class, 'create']) ->name('create');
Route::post('/store', [HomeController::class, 'store']) ->name('store');
Route::middleware('auth')->get('/create', [HomeController::class, 'create'])->name('create');
// Route สำหรับหน้าเข้าสู่ระบบ
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
// Route สำหรับการส่งข้อมูลเข้าสู่ระบบ
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
// Route สำหรับการแสดงฟอร์มสมัครสมาชิก
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');

// Route สำหรับการบันทึกการสมัครสมาชิก
Route::post('/register', [RegisteredUserController::class, 'store']);
<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;


Route::get('/', [HomeController::class, 'index']) ->name('index');
Route::get('/create', [HomeController::class, 'create']) ->name('create');
Route::post('/store', [HomeController::class, 'store']) ->name('store');
Route::post('/post/{home_id}/comment', [CommentController::class, 'store'])->name('comment.store');
Route::get('/post/{home}', [HomeController::class, 'show'])->name('show');
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
// Route สำหรับการออกจากระบบ
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // เส้นทางสำหรับหน้าโปรไฟล์
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    // เส้นทางสำหรับการแก้ไขโปรไฟล์
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // เส้นทางสำหรับการเปลี่ยนรหัสผ่าน
    Route::get('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
    Route::put('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});

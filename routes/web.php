<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommetnController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| 🔐 Guest only (login / register)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login',   [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register',[RegisteredUserController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| 🌐 Public (no auth)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('categories.show');
Route::get('/posts/{home}', [HomeController::class, 'show'])
    ->whereNumber('home')
    ->name('posts.show');

/*
|--------------------------------------------------------------------------
| 🧑‍💻 Auth required
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Posts CRUD
    Route::get('/posts/create',      [\App\Http\Controllers\HomeController::class, 'create'])->name('posts.create');
    Route::post('/posts',            [\App\Http\Controllers\HomeController::class, 'store'])->name('posts.store');
    Route::get('/posts/{home}/edit', [\App\Http\Controllers\HomeController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{home}',      [\App\Http\Controllers\HomeController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{home}',   [\App\Http\Controllers\HomeController::class, 'destroy'])->name('posts.destroy');

    // (ถ้าจะใช้คอมเมนต์ผ่าน HomeController ตามของคุณ ให้คงไว้)
    Route::post('/post/{home}/comment',                 [\App\Http\Controllers\HomeController::class, 'storeComment'])->name('comment.store');
    Route::put('/post/{home}/comment/{comment}',        [\App\Http\Controllers\HomeController::class, 'updateComment'])->name('comment.update');
    Route::delete('/post/{home}/comment/{comment}',     [\App\Http\Controllers\HomeController::class, 'destroyComment'])->name('comment.destroy');

    // Profile
    Route::get('/profile',            [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit',       [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',            [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password',   [ProfileController::class, 'passwordForm'])->name('profile.password');
    Route::put('/profile/password',   [ProfileController::class, 'passwordUpdate'])->name('profile.password.update');

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| 🛡 Admin only
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard'); 
        Route::resource('categories', AdminCategoryController::class)->except(['show']);
        // เพิ่ม resource routes สำหรับจัดการผู้ใช้ (admin.users.*)
        Route::resource('users', AdminUserController::class)->except(['show']);
    });

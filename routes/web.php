<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

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
    Route::get('/posts/create',      [HomeController::class, 'create'])->name('posts.create');
    Route::post('/posts',            [HomeController::class, 'store'])->name('posts.store');
    Route::get('/posts/{home}/edit', [HomeController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{home}',      [HomeController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{home}',   [HomeController::class, 'destroy'])->name('posts.destroy');

    // Comments
    Route::post('/post/{home}/comment',                 [HomeController::class, 'storeComment'])->name('comment.store');
    Route::put('/post/{home}/comment/{comment}',        [HomeController::class, 'updateComment'])->name('comment.update');
    Route::delete('/post/{home}/comment/{comment}',     [HomeController::class, 'destroyComment'])->name('comment.destroy');

    // Profile
    Route::get('/profile',            [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit',       [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',            [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password',   [ProfileController::class, 'passwordForm'])->name('profile.password');
    Route::put('/profile/password',   [ProfileController::class, 'passwordUpdate'])->name('profile.password.update');

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

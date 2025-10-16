<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| 🌐 Public Pages (ไม่ต้องล็อกอิน)
|--------------------------------------------------------------------------
*/

// หน้าแรก (ลิสต์โพสต์ทั้งหมด)
Route::get('/', [HomeController::class, 'index'])->name('index');

// ดูโพสต์ตามหมวดหมู่
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('categories.show');

// เพิ่มคอมเมนต์ (ต้องล็อกอิน)
Route::post('/post/{home}/comment', [HomeController::class, 'storeComment'])
    ->middleware('auth')
    ->name('comment.store');


/*
|--------------------------------------------------------------------------
| 🧑‍💻 Auth Required (ต้องล็อกอินก่อน)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    /*
    |---------------------------------------
    | 🏠 จัดการโพสต์ของผู้ใช้ (CRUD)
    |---------------------------------------
    | ระวังลำดับ: เส้นทางแบบเจาะจง (create/edit) ต้องมาก่อน {home}
    */
    Route::get('/posts/create',        [HomeController::class, 'create'])->name('posts.create');
    Route::post('/posts',              [HomeController::class, 'store'])->name('posts.store');

    Route::get('/posts/{home}/edit',   [HomeController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{home}',        [HomeController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{home}',     [HomeController::class, 'destroy'])->name('posts.destroy');

    /*
    |---------------------------------------
    | 👤 โปรไฟล์และข้อมูลส่วนตัว
    |---------------------------------------<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| 🔐 Authentication Routes (เข้าสู่ระบบ / สมัครสมาชิก)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

/*
|--------------------------------------------------------------------------
| 🌐 Public Pages (ไม่ต้องล็อกอิน)
|--------------------------------------------------------------------------
*/

// หน้าแรก (ลิสต์โพสต์ทั้งหมด)
Route::get('/', [HomeController::class, 'index'])->name('index');

// ดูโพสต์ตามหมวดหมู่
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('categories.show');

// เพิ่มคอมเมนต์ (ต้องล็อกอิน)
Route::post('/post/{home}/comment', [HomeController::class, 'storeComment'])
    ->middleware('auth')
    ->name('comment.store');

/*
|--------------------------------------------------------------------------
| 🧑‍💻 Auth Required (ต้องล็อกอินก่อน)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    /*
    |---------------------------------------
    | 🏠 จัดการโพสต์ของผู้ใช้ (CRUD)
    |---------------------------------------
    */
    Route::get('/posts/create', [HomeController::class, 'create'])->name('posts.create');
    Route::post('/posts', [HomeController::class, 'store'])->name('posts.store');
    Route::get('/posts/{home}/edit', [HomeController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{home}', [HomeController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{home}', [HomeController::class, 'destroy'])->name('posts.destroy');

    /*
    |---------------------------------------
    | 👤 โปรไฟล์และข้อมูลส่วนตัว
    |---------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/profile/password', [ProfileController::class, 'passwordForm'])->name('profile.password');
    Route::put('/profile/password', [ProfileController::class, 'passwordUpdate'])->name('profile.password.update');

    // ออกจากระบบ
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| 🔎 Public: ดูโพสต์เดี่ยว (ต้องวางท้ายสุด)
|--------------------------------------------------------------------------
*/
Route::get('/posts/{home}', [HomeController::class, 'show'])
    ->whereNumber('home') // ป้องกันชนกับ /posts/create
    ->name('posts.show');


    Route::get('/profile',             [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit',        [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',             [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/profile/password',    [ProfileController::class, 'passwordForm'])->name('profile.password');
    Route::put('/profile/password',    [ProfileController::class, 'passwordUpdate'])->name('profile.password.update');

    // ออกจากระบบ
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| 🔎 Public: ดูโพสต์เดี่ยว (ต้องวางท้ายสุด + จำกัดพารามิเตอร์)
|--------------------------------------------------------------------------
*/
Route::get('/posts/{home}', [HomeController::class, 'show'])
    ->whereNumber('home')   // รับเฉพาะตัวเลข ป้องกันชนกับ /posts/create
    ->name('posts.show');

<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\VipController;
use App\Http\Middleware\AdminOnly;
use Illuminate\Support\Facades\Route;

// ----- Công khai
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/phim', [HomeController::class, 'movies'])->name('movies.index');
Route::get('/phim/{movie}', [HomeController::class, 'show'])->name('movies.show')->whereNumber('movie');
Route::get('/lien-he', [HomeController::class, 'contactForm'])->name('contact');
Route::post('/lien-he', [HomeController::class, 'contactSend'])->name('contact.send');
Route::get('/goi-vip', [VipController::class, 'index'])->name('vip.index');

// ----- Khách
Route::middleware('guest')->group(function () {
    Route::get('/dang-nhap', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/dang-nhap', [AuthController::class, 'login']);
    Route::get('/dang-ky', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/dang-ky', [AuthController::class, 'register']);
});

// ----- Thành viên
Route::middleware('auth')->group(function () {
    Route::post('/dang-xuat', [AuthController::class, 'logout'])->name('logout');

    Route::get('/phim/{movie}/xem/{episode?}', [HomeController::class, 'watch'])->name('movies.watch');
    Route::post('/phim/{movie}/binh-luan', [InteractionController::class, 'comment'])->name('movies.comment');
    Route::post('/phim/{movie}/danh-gia', [InteractionController::class, 'rate'])->name('movies.rate');
    Route::post('/phim/{movie}/yeu-thich', [InteractionController::class, 'favorite'])->name('movies.favorite');

    Route::get('/tai-khoan/yeu-thich', [AccountController::class, 'favorites'])->name('account.favorites');
    Route::get('/tai-khoan/lich-su', [AccountController::class, 'history'])->name('account.history');
    Route::get('/tai-khoan/ho-so', [AccountController::class, 'profile'])->name('account.profile');
    Route::put('/tai-khoan/ho-so', [AccountController::class, 'updateProfile'])->name('account.profile.update');

    Route::post('/goi-vip/{plan}/mua', [VipController::class, 'buy'])->name('vip.buy');
});

// ----- Quản trị
Route::prefix('admin')->name('admin.')->middleware(['auth', AdminOnly::class])->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('movies', Admin\MovieController::class)->except('show');
    Route::post('movies/{movie}/episodes', [Admin\MovieController::class, 'storeEpisode'])->name('episodes.store');
    Route::delete('episodes/{episode}', [Admin\MovieController::class, 'destroyEpisode'])->name('episodes.destroy');

    Route::resource('categories', Admin\CategoryController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::get('users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::post('users/{user}/toggle', [Admin\UserController::class, 'toggle'])->name('users.toggle');

    Route::get('comments', [Admin\CommentController::class, 'index'])->name('comments.index');
    Route::delete('comments/{comment}', [Admin\CommentController::class, 'destroy'])->name('comments.destroy');
});

<?php

use App\Http\Controllers as CT;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});

Route::get('login', [CT\Auth\AuthController::class, 'index'])->name('login');

Route::group(['prefix' => 'auth'], function () {
    Route::post('/check_login_web', [CT\Auth\AuthController::class, 'check_login_web'])->name('auth.check_login_web');
    Route::post('/auth/logout_web', [CT\Auth\AuthController::class, 'logout'])->name('auth.logout_web')->middleware('auth');;
});

Route::get('dashboard', [CT\Dashboard\DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/data', [CT\Dashboard\DashboardController::class, 'getDashboardData'])->name('data.dashboard');

Route::group(['prefix' => 'master', 'middleware' => 'auth'], function () {
    Route::get('/user', [CT\Master\UserController::class, 'index'])->name('master.user');
    Route::get('/category', [CT\Master\CategoryController::class, 'index'])->name('master.category');
    Route::get('/product', [CT\Master\ProductController::class, 'index'])->name('master.product');
    Route::get('/location', [CT\Master\LocationController::class, 'index'])->name('master.location');
});


Route::group(['prefix' => 'mutation'], function () {
    Route::get('/', [CT\Data_Mutation\MutationController::class, 'index'])->name('mutation.index');
});

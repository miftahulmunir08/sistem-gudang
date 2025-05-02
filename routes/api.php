<?php

use App\Http\Controllers as CT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login/', [CT\Auth\AuthController::class, 'check_login_api'])->name('auth.check_login_api');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout/', [CT\Auth\AuthController::class, 'logout']);
});


Route::apiResource('pegawai', CT\Master\PegawaiController::class)->middleware('auth:sanctum');
Route::apiResource('categories', CT\Master\CategoryController::class)->middleware('auth:sanctum');
Route::apiResource('products', CT\Master\ProductController::class)->middleware('auth:sanctum');



Route::group(['prefix' => 'pegawai-action', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/data', [CT\Master\PegawaiController::class, 'getData'])->name('data.pegawai');
    Route::get('/all', [CT\Master\PegawaiController::class, 'getAll'])->name('data.pegawai.all');
});


Route::group(['prefix' => 'category-action', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/data', [CT\Master\CategoryController::class, 'getData'])->name('data.category');
    Route::get('/all', [CT\Master\CategoryController::class, 'getAll'])->name('data.category.all');
});

Route::group(['prefix' => 'product-action', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/data', [CT\Master\ProductController::class, 'getData'])->name('data.product');
    Route::get('/all', [CT\Master\ProductController::class, 'getAll'])->name('data.product.all');
});




// Route::group(['prefix' => 'auth', 'middleware' => 'auth:sanctum'], function () {
//     Route::post('/', [CT\Auth\AuthController::class, 'check_login_api'])->name('auth.check_login_api');
// });

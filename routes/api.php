<?php

use App\Http\Controllers as CT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login/', [CT\Auth\AuthController::class, 'check_login_api'])->name('auth.check_login_api');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout/', [CT\Auth\AuthController::class, 'logout']);
});


Route::apiResource('user', CT\Master\UserController::class)->middleware('auth:sanctum');
Route::get('user/get/', [CT\Master\UserController::class, 'get'])->middleware('auth:sacntum');
// Route::group(['prefix' => 'auth', 'middleware' => 'auth:sanctum'], function () {
//     Route::post('/', [CT\Auth\AuthController::class, 'check_login_api'])->name('auth.check_login_api');
// });

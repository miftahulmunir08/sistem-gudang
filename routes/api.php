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
Route::apiResource('locations', CT\Master\LocationController::class)->middleware('auth:sanctum');
Route::apiResource('mutations', CT\Data_Mutation\MutationController::class)->middleware('auth:sanctum');


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

Route::group(['prefix' => 'location-action', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/data', [CT\Master\LocationController::class, 'getData'])->name('data.location');
    Route::get('/all', [CT\Master\LocationController::class, 'getAll'])->name('data.location.all');
});

Route::group(['prefix' => 'mutation-action', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/data', [CT\Data_Mutation\MutationController::class, 'getData'])->name('data.mutation');
    Route::get('/all', [CT\Data_Mutation\MutationController::class, 'getAll'])->name('data.mutation.all');
});


Route::group(['prefix' => 'utility-action', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/type_all_mutation', [CT\Utility\UtilityController::class, 'getAllMutation'])->name('data.utilty-type-mutasi.all');
});


Route::group(['prefix' => 'filter-action'], function () {
    Route::get('/data-filter-history-mutation', [CT\History\MutationHistoryController::class, 'filter'])->name('data.history.filter-mutation');
    Route::post('/filter-history-mutation-all', [CT\History\MutationHistoryController::class, 'filter_api'])->name('data.history.filter-mutation-all');
});




// Route::group(['prefix' => 'auth', 'middleware' => 'auth:sanctum'], function () {
//     Route::post('/', [CT\Auth\AuthController::class, 'check_login_api'])->name('auth.check_login_api');
// });

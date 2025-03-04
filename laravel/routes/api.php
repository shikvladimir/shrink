<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'link', 'middleware' => 'auth:sanctum'], function () {
    Route::get('get',               [LinkController::class, 'useGet'])->withoutMiddleware('auth:sanctum');
    Route::post('store',            [LinkController::class, 'useStore']);
    Route::put('update',            [LinkController::class, 'useUpdate']);
    Route::delete('delete/{alias}', [LinkController::class, 'useDelete']);
    Route::get('count',             [LinkController::class, 'useCount']);
});


Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function () {
    Route::get('get',               [UserController::class, 'useGet'])->withoutMiddleware('auth:sanctum');
    Route::post('registr',          [UserController::class, 'useRegistr'])->withoutMiddleware('auth:sanctum');
    Route::post('login',            [UserController::class, 'useLogin'])->withoutMiddleware('auth:sanctum');
    Route::post('logout',           [UserController::class, 'useLogout']);
});

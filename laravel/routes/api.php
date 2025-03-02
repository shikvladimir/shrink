<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'link'], function () {
    Route::get('get',               [LinkController::class, 'useGet']);
    Route::post('store',            [LinkController::class, 'useStore']);
    Route::put('update',            [LinkController::class, 'useUpdate']);
    Route::delete('delete/{alias}', [LinkController::class, 'useDelete']);
    Route::get('count',             [LinkController::class, 'useCount']);
});

Route::group(['prefix' => 'user'], function () {
    Route::get('get',               [UserController::class, 'useGet']);
    Route::post('registr',          [UserController::class, 'useRegistr']);
    Route::post('login',            [UserController::class, 'useLogin']);
    Route::post('logout',           [UserController::class, 'useLogout']);
});

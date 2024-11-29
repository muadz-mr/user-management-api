<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'user'], function () {
    Route::post('add', [UserController::class, 'store']);
    Route::post('edit', [UserController::class, 'update']);
    Route::post('delete', [UserController::class, 'destroy']);
});

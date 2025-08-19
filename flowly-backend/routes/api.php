<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticated;
use Illuminate\Support\Facades\Route;

Route::resource('tasks', TaskController::class)->only([
    'index',
    'store',
    'show',
    'update',
    'destroy',
])->middleware(Authenticated::class);

Route::resource('users', UserController::class)->only([
    'show',
    'update',
    'destroy',
])->middleware(Authenticated::class);

Route::prefix('auth')->group(function () {
    Route::post('/login', [LoginController::class, 'store']);
    Route::post('/register', [RegisterController::class, 'store']);
});

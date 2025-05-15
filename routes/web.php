<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class);

Route::middleware('guest')->group(function () {
    Route::get('/login', [SessionController::class, 'create']);
    Route::get('/register', [RegisterController::class, 'create']);
});

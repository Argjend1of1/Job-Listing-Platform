<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['guest:sanctum'])->group(function () {
    Route::post('/login', [SessionController::class, 'store']);
    Route::post('/register', [RegisterController::class, 'store']);
});

//for routes that will be role protected, for example admin:
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [SessionController::class, 'index']);
    Route::delete('/logout', [SessionController::class, 'destroy']);
});

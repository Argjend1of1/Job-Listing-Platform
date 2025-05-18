<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
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

Route::middleware([
    'auth:sanctum', 'role:user,employer,superemployer,admin'
])->group(function () {
    Route::get('/account', [AccountController::class, 'show']);
    Route::get('/account/edit', [AccountController::class, 'show']);
    Route::patch('/account/edit', [AccountController::class, 'update']);
    Route::delete('/account/edit', [AccountController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'role:employer,superemployer'])->group(function () {
    Route::post('/jobs/create', [JobController::class, 'store']);

    Route::get('/dashboard', [DashboardController::class, 'show']);
    Route::patch('/dashboard/edit/{job}', [DashboardController::class, 'update']);
    Route::delete('/dashboard/edit/{job}', [DashboardController::class, 'destroy']);
});

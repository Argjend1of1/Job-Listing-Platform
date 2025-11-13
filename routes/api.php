<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\PremiumEmployerController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//for routes that will be role protected, for example admin:
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [SessionController::class, 'index']);
    Route::delete('/logout', [SessionController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
    Route::delete('/jobs/{job}/bookmark', [BookmarkController::class, 'destroy']);
});

Route::middleware([
    'auth:sanctum', 'role:user,employer,superemployer,admin'
])->group(function () {
    Route::get('/account', [AccountController::class, 'show']);
    Route::get('/account/edit', [AccountController::class, 'show']);
    Route::patch('/account/edit', [AccountController::class, 'update']);
    Route::delete('/account/edit', [AccountController::class, 'destroy']);
});

//authenticated admin,superadmin
Route::middleware(['auth:sanctum', 'role:admin,superadmin'])->group(function () {
    Route::patch('/premiumEmployers/{id}', [PremiumEmployerController::class, 'update']);
});

//authenticated superadmin
Route::middleware(['auth:sanctum', 'role:superadmin'])->group(function () {
    Route::patch('/admins/create/{user}', [UserController::class, 'update']);
});

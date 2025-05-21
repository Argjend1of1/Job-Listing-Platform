<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PremiumEmployerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// all users so we can show a message to the user that he must be logged in
// to apply, and have a resume uploaded
Route::post('/jobs/{id}/apply', [ApplicationController::class, 'store']);
Route::post('/jobs/{job}/bookmark', [BookmarkController::class, 'store']);

Route::middleware(['guest:sanctum'])->group(function () {
    Route::post('/login', [SessionController::class, 'store']);
    Route::post('/register', [RegisterController::class, 'store']);
});

//for routes that will be role protected, for example admin:
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [SessionController::class, 'index']);
    Route::delete('/logout', [SessionController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
    Route::post('/resume', [ResumeController::class, 'store']);
    Route::delete('/jobs/{job}/bookmark', [BookmarkController::class, 'destroy']);
});

Route::middleware([
    'auth:sanctum', 'role:user,employer,superemployer,admin'
])->group(function () {
    Route::get('/account', [AccountController::class, 'show']);
    Route::get('/account/edit', [AccountController::class, 'show']);
    Route::patch('/account/edit', [AccountController::class, 'update']);
    Route::delete('/account/edit', [AccountController::class, 'destroy']);

    Route::post('/jobs/{job}/report', [ReportController::class, 'store']);
});

Route::middleware(['auth:sanctum', 'role:employer,superemployer'])->group(function () {
    Route::post('/jobs/create', [JobController::class, 'store']);

    Route::get('/dashboard', [DashboardController::class, 'show']);
    Route::patch('/dashboard/edit/{job}', [DashboardController::class, 'update']);
    Route::delete('/dashboard/edit/{job}', [DashboardController::class, 'destroy']);
});

//authenticated admin,superadmin
Route::middleware(['auth:sanctum', 'role:admin,superadmin'])->group(function () {
    Route::patch('/employers/{id}', [EmployerController::class, 'update']);
    Route::delete('/employers/{id}', [EmployerController::class, 'destroy']);
    Route::patch('/premiumEmployers/{id}', [PremiumEmployerController::class, 'update']);

    Route::delete('/jobs/{job}/destroy', [JobController::class, 'destroy']);
});

//authenticated superadmin
Route::middleware(['auth:sanctum', 'role:superadmin'])->group(function () {
    Route::patch('/admins/create/{user}', [UserController::class, 'update']);
    Route::patch('/admins/{id}', [AdminController::class, 'update']);
});

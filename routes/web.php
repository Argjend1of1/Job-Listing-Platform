<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PremiumEmployerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class);

Route::middleware('guest')->group(function () {
    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::get('/register', [RegisterController::class, 'create']);
});

//authenticated with selected roles
Route::middleware(['auth', 'role:user,employer,superemployer,admin'])->group(function () {
    Route::get('/account', [AccountController::class, 'index']);
    Route::get('/account/edit', [AccountController::class, 'edit']);
});

//authenticated employer, superemployer
Route::middleware(['auth', 'role:employer,superemployer'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/edit/{job}', [DashboardController::class, 'edit']);
    Route::get('/jobs/create', [JobController::class, 'create']);
});

//authenticated admin, superadmin
Route::middleware(['auth', 'role:admin,superadmin'])->group(function () {
    Route::get('/employers', [EmployerController::class, 'index']);
    Route::get('/premiumEmployers', [PremiumEmployerController::class, 'index']);
});

//authenticated superadmin
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/admins', [AdminController::class, 'index']);
    Route::get('/admins/create', [UserController::class, 'index']);
});

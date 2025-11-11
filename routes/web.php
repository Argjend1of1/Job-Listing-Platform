<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PremiumEmployerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//guests
Route::middleware('guest')->group(function () {
    Route::get('/login', [SessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [SessionController::class, 'store']);

    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);

    Route::get('/forgot-password', [PasswordResetController::class, 'index']);
    Route::get('/reset-password', [PasswordResetController::class, 'edit']);
});

//auth with users role only
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/resume', [ResumeController::class, 'index']);
    Route::post('/resume', [ResumeController::class, 'store']);

    //!!!! Inertia Completed note: if a space between routes that route has not been checked !!!!
    Route::get('/bookmarks', [BookmarkController::class, 'index']);
    Route::get('/jobs/{job}/bookmark', [BookmarkController::class, 'show']);
    Route::post('/jobs/{job}/bookmark', [BookmarkController::class, 'store']);
    Route::delete('/jobs/{job}/bookmark', [BookmarkController::class, 'destroy']);

    //!!!! Inertia Completed note: if a space between routes that route has not been checked !!!!
    Route::post('/jobs/{id}/apply', [ApplicationController::class, 'store']);
});

//authenticated with selected roles
Route::middleware(['auth', 'role:user,employer,superemployer,admin'])->group(function () {
    //!!!! Inertia Completed note: if a space between routes that route has not been checked !!!!
    Route::get('/account', [AccountController::class, 'index']);
    Route::get('/account/edit', [AccountController::class, 'edit']);
    Route::patch('/account/edit', [AccountController::class, 'update']);
    Route::delete('/account/edit', [AccountController::class, 'destroy']);

    //!!!! Inertia Completed note: if a space between routes that route has not been checked !!!!
    Route::post('/jobs/{job}/report', [ReportController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::delete('/logout', [SessionController::class, 'destroy']);
});

//authenticated employer, superemployer
Route::middleware(['auth', 'role:employer,superemployer'])->group(function () {
    //!!!! Inertia Completed note: if a space between routes that route has not been checked !!!!
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/edit/{job}', [DashboardController::class, 'edit']);
    Route::patch('/dashboard/edit/{job}', [DashboardController::class, 'update']);
    Route::delete('/dashboard/edit/{job}', [DashboardController::class, 'destroy']);

    //!!!! Inertia Completed note: if a space between routes that route has not been checked !!!!
    Route::get('/jobs/create', [JobController::class, 'create']);
    Route::post('/jobs/create', [JobController::class, 'store']);

    Route::get('/dashboard/{job}/applicants', [ApplicationController::class, 'show']);
    Route::get('/resume/{user}/{job}', [ResumeController::class, 'show'])
        ->name('resume.download');
});

//authenticated admin, superadmin
Route::middleware(['auth', 'role:admin,superadmin'])->group(function () {
    Route::get('/employers', [EmployerController::class, 'index']);
    Route::get('/premiumEmployers', [PremiumEmployerController::class, 'index']);

    Route::get('/reports', [ReportController::class, 'index']);

    //!!!! Inertia Completed note: if a space between routes that route has not been checked !!!!
    Route::delete('/jobs/{job}/destroy', [JobController::class, 'destroy']);
});

//authenticated superadmin
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/admins', [AdminController::class, 'index']);
    Route::patch('/admins/{id}', [AdminController::class, 'update']);
    Route::get('/admins/create', [UserController::class, 'index']);
});

//accessible from everyone
Route::get('/', HomeController::class);
Route::get('/companies', [CompanyController::class, 'index']);
Route::get('/companies/{id}/jobs', [CompanyController::class, 'show']);

Route::get('/categories/{name}', [CategoryController::class, 'index']);

//!!!! Inertia Completed note: if a space between routes that route has not been checked !!!!
Route::get('/jobs', [JobController::class, 'index']);
Route::get('/jobs/top', [JobController::class, 'top']);
Route::get('/jobs/more', [JobController::class, 'more']);
Route::get('/jobs/{job}', [JobController::class, 'show']);

Route::get('/tags/{tag:name}', TagController::class);//{tag:name} - frontend


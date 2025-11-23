<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PremiumEmployerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Unauthorized users
 */
Route::middleware('guest')->group(function () {
    Route::get('/login', [SessionController::class, 'index'])
        ->name('login');

    Route::post('/login', [SessionController::class, 'store']);

    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);

    /**
     * Resetting a users' password
     */
    Route::get('/forgot-password', [ResetPasswordController::class, 'index'])
        ->name('password.request');

    Route::post('/forgot-password', [ResetPasswordController::class, 'store'])
        ->name('password.email');

    Route::get('/forgot-password/email-sent', [ResetPasswordController::class, 'wait'])
        ->name('password.request');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'edit'])
        ->name('password.reset');

    Route::post('/reset-password', [ResetPasswordController::class, 'update'])
        ->name('password.update');
});

/**
 * Regular authenticated users
 */
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/resume', [ResumeController::class, 'index']);
    Route::post('/resume', [ResumeController::class, 'store']);

    Route::get('/bookmarks', [BookmarkController::class, 'index']);
    Route::get('/jobs/{job}/bookmark', [BookmarkController::class, 'show']);
    Route::post('/jobs/{job}/bookmark', [BookmarkController::class, 'store']);
    Route::delete('/jobs/{job}/bookmark', [BookmarkController::class, 'destroy']);

    Route::post('/jobs/{id}/apply', [ApplicationController::class, 'store']);
});

/**
 * Authenticated with specified roles
 */
Route::middleware(['auth', 'verified', 'role:user,employer,superemployer,admin'])->group(function () {
    Route::get('/account', [AccountController::class, 'index']);
    Route::get('/account/edit', [AccountController::class, 'edit']);
    Route::patch('/account/edit', [AccountController::class, 'update']);
    Route::delete('/account/edit', [AccountController::class, 'destroy']);

    Route::post('/jobs/{job}/report', [ReportController::class, 'store']);
});

/**
 * All authenticated users
 */
Route::middleware('auth')->group(function () {

    /**
     * Email verification process.
     */
    Route::get('/email/verify', function () {
        return inertia('auth/VerifyEmail');
    })->name('verification.notice');

    Route::get('email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()
            ->intended('/')
            ->with('success', 'Email verified successfully. You may proceed.');
    })
    ->middleware('signed')
    ->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent. Please check your email!');
    })
    ->middleware(['throttle:6,1'])
    ->name('verification.send');


    Route::delete('/logout', [SessionController::class, 'destroy']);
});

/**
 * Authenticated as an employer
 */
Route::middleware(['auth', 'role:employer,superemployer'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/edit/{job}', [DashboardController::class, 'edit']);
    Route::patch('/dashboard/edit/{job}', [DashboardController::class, 'update']);
    Route::delete('/dashboard/edit/{job}', [DashboardController::class, 'destroy']);

    Route::get('/jobs/create', [JobController::class, 'create']);
    Route::post('/jobs/create', [JobController::class, 'store']);

    Route::get('/dashboard/{job}/applicants', [ApplicationController::class, 'show']);
    Route::get('/resume/{user}/{job}', [ResumeController::class, 'show'])
        ->name('resume.download');
});

/**
 * Authenticated admins
 */
Route::middleware(['auth', 'role:admin,superadmin'])->group(function () {
    Route::get('/employers', [EmployerController::class, 'index']);
    Route::patch('/employers/{id}', [EmployerController::class, 'update']);
    Route::delete('/employers/{id}', [EmployerController::class, 'destroy']);
    Route::get('/premiumEmployers', [PremiumEmployerController::class, 'index']);

    Route::get('/reports', [ReportController::class, 'index']);

    Route::delete('/jobs/{job}/destroy', [JobController::class, 'destroy']);
});

/**
 * Authenticated premium admin only
 */
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/admins', [AdminController::class, 'index']);
    Route::patch('/admins/{id}', [AdminController::class, 'update']);
    Route::get('/admins/create', [UserController::class, 'index']);
    Route::patch('/admins/create/{user}', [UserController::class, 'update']);
});

/**
 * Routes accessible by everyone.
 */
Route::get('/', HomeController::class)->name('home');
Route::get('/companies', [CompanyController::class, 'index']);
Route::get('/companies/{id}/jobs', [CompanyController::class, 'show']);

Route::get('/jobs', [JobController::class, 'index']);
Route::get('/jobs/top', [JobController::class, 'top']);
Route::get('/jobs/more', [JobController::class, 'more']);
Route::get('/jobs/{job}', [JobController::class, 'show']);

Route::get('/categories/{name}', [CategoryController::class, 'index']);
Route::get('/tags/{tag:name}', TagController::class);


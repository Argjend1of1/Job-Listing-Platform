<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//authenticated superadmin
Route::middleware(['auth:sanctum', 'role:superadmin'])->group(function () {
    Route::patch('/admins/create/{user}', [UserController::class, 'update']);
});

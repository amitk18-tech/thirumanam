<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Rbac\UserController;



Route::prefix('user')->group(function () {

    Route::get('/', [UserController::class, 'index']); // List all users
    Route::post('/', [UserController::class, 'store']); // Create new user
    Route::get('/{id}', [UserController::class, 'show']); // View single user
    Route::post('/{id}', [UserController::class, 'update']); // Full update
    Route::delete('/{id}', [UserController::class, 'destroy']); // Delete user
});
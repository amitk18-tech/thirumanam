<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Profile\ProfileController;



Route::prefix('profile')->group(function () {

    Route::get('/', [ProfileController::class, 'index']); // List all partner preferences
    Route::post('/', [ProfileController::class, 'store']); // Create new partner preference
    Route::get('/{id}', [ProfileController::class, 'show']); // View single partner preference
    Route::post('/{id}', [ProfileController::class, 'update']); // Full update
    Route::delete('/{id}', [ProfileController::class, 'destroy']); // Delete partner preference

    Route::get('/user/{userId}', [ProfileController::class, 'getByUserId']); // Get profile by user ID

    // Admin actions
    Route::post('/{id}/approve', [ProfileController::class, 'approveProfile']); // Approve profile
    Route::post('/{id}/reject', [ProfileController::class, 'rejectProfile']); // Reject profile
    Route::post('/{id}/block', [ProfileController::class, 'blockProfile']); // Block profile


    // List profiles with filters and joins
    Route::get('/list', [ProfileController::class, 'list']); // List profiles with filters and joins

    // get profile by user id with joins
    Route::get('/detailed/user/{userId}', [ProfileController::class, 'getProfileByUserId']); // Get detailed profile by user ID with joins

});
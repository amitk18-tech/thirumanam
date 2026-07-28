<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Profile\ProfileVerificationLogController;



Route::prefix('profile-verification')->group(function () {
    // 🔁 Bulk operations
    Route::post('/bulk-delete', [ProfileVerificationLogController::class, 'bulkDelete']);
    Route::post('/bulk-update', [ProfileVerificationLogController::class, 'bulkUpdate']);

    // 🧾 Standard CRUD routes
    Route::get('/', [ProfileVerificationLogController::class, 'index']); // List all partner preferences
    Route::post('/', [ProfileVerificationLogController::class, 'store']); // Create new partner preference
    Route::get('/{id}', [ProfileVerificationLogController::class, 'show']); // View single partner preference
    Route::post('/{id}', [ProfileVerificationLogController::class, 'update']); // Full update
    Route::delete('/{id}', [ProfileVerificationLogController::class, 'destroy']); // Delete partner preference
});
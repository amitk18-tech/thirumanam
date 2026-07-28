<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Memberships\MembershipController;



Route::prefix('membership')->group(function () {
    // 🔁 Bulk operations
    Route::post('/bulk-delete', [MembershipController::class, 'bulkDelete']);
    Route::post('/bulk-update', [MembershipController::class, 'bulkUpdate']);

    // 🧾 Standard CRUD routes
    Route::get('/', [MembershipController::class, 'index']); // List all partner preferences
    Route::post('/', [MembershipController::class, 'store']); // Create new partner preference
    Route::get('/{id}', [MembershipController::class, 'show']); // View single partner preference
    Route::post('/{id}', [MembershipController::class, 'update']); // Full update
    Route::delete('/{id}', [MembershipController::class, 'destroy']); // Delete partner preference
});
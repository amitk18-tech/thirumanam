<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Profile\PartnerPreferenceController;



Route::prefix('partner-preference')->group(function () {
    // 🔁 Bulk operations
    Route::post('/bulk-delete', [PartnerPreferenceController::class, 'bulkDelete']);
    Route::post('/bulk-update', [PartnerPreferenceController::class, 'bulkUpdate']);

    // 🧾 Standard CRUD routes
    Route::get('/', [PartnerPreferenceController::class, 'index']); // List all partner preferences
    Route::post('/', [PartnerPreferenceController::class, 'store']); // Create new partner preference
    Route::get('/{id}', [PartnerPreferenceController::class, 'show']); // View single partner preference
    Route::post('/{id}', [PartnerPreferenceController::class, 'update']); // Full update
    Route::delete('/{id}', [PartnerPreferenceController::class, 'destroy']); // Delete partner preference
});
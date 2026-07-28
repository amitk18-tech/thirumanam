<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Matches\MatchActionController;



Route::prefix('match-action')->group(function () {
    // 🔁 Bulk operations
    Route::post('/bulk-delete', [MatchActionController::class, 'bulkDelete']);
    Route::post('/bulk-update', [MatchActionController::class, 'bulkUpdate']);

    // 🧾 Standard CRUD routes
    Route::get('/', [MatchActionController::class, 'index']); // List all matches
    Route::post('/', [MatchActionController::class, 'store']); // Create new match
    Route::get('/{id}', [MatchActionController::class, 'show']); // View single match
    Route::post('/{id}', [MatchActionController::class, 'update']); // Full update
    Route::delete('/{id}', [MatchActionController::class, 'destroy']); // Delete match

    // New action routes
    Route::post('/{receiverId}/interest', [MatchActionController::class, 'sendInterest']);
    Route::post('/{receiverId}/like', [MatchActionController::class, 'like']);
    Route::post('/{receiverId}/shortlist', [MatchActionController::class, 'shortlist']);
    Route::get('/who-shortlisted-me', [MatchActionController::class, 'whoShortlistedMe']);
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Matches\MatrimonyController;
use App\Http\Controllers\InvoiceController;

Route::prefix('matrimony')->group(function () {
    // Profile Search & Matches
    Route::get('/search', [MatrimonyController::class, 'search']);
    Route::get('/matches', [MatrimonyController::class, 'matches']);
    Route::get('/new-members', [MatrimonyController::class, 'newMembers']);
    Route::get('/profile/{id}', [MatrimonyController::class, 'profileDetails']);

    // Engagement (who interacted with me)
    Route::get('/who-liked-me', [MatrimonyController::class, 'whoLikedMe']);
    Route::get('/who-shortlisted-me', [MatrimonyController::class, 'whoShortlistedMe']);
    Route::get('/who-viewed-me', [MatrimonyController::class, 'whoViewedMyProfile']);
    Route::get('/who-messaged-me', [MatrimonyController::class, 'whoMessagedMe']);
    Route::get('/who-contacted-me', [MatrimonyController::class, 'whoContactedMe']);
});

Route::get('invoices/pdf', [InvoiceController::class, 'generatePdf']);
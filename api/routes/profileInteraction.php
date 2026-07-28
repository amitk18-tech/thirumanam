<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileInteractionController;

Route::prefix('interaction')->group(function () {
    Route::get('/interests', [ProfileInteractionController::class, 'getInterests']);
    Route::get('/follow-stats', [ProfileInteractionController::class, 'getFollowStats']);








    Route::post('/toggle-action', [ProfileInteractionController::class, 'toggleAction']);
    Route::post('/interest', [ProfileInteractionController::class, 'sendInterest']);
    Route::get('/shortlisted', [ProfileInteractionController::class, 'getShortlisted']);
    Route::post('/shortlist', [ProfileInteractionController::class, 'createShortlist']);

    Route::post('/follow', [ProfileInteractionController::class, 'createFollower']);



    Route::post('/respond/{id}', [ProfileInteractionController::class, 'respondToInterest']);
    Route::post('/action', [ProfileInteractionController::class, 'performAction']);
    Route::post('/undo', [ProfileInteractionController::class, 'undoAction']);
    Route::post('/report', [ProfileInteractionController::class, 'reportProfile']);
    Route::get('/', [ProfileInteractionController::class, 'index']);
    Route::post('/consume-view', [ProfileInteractionController::class, 'consumeProfileView']);
    Route::get('/follows', [ProfileInteractionController::class, 'getFollows']);
    Route::get('/blocked', [ProfileInteractionController::class, 'getBlockedList']);
    Route::post('/block', [ProfileInteractionController::class, 'createBlock']);
    Route::get('/shortlisted', [ProfileInteractionController::class, 'shorlisted']);
});
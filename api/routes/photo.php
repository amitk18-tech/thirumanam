<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Profile\PhotoController;



Route::prefix('photo')->group(function () {

    Route::get('/', [PhotoController::class, 'index']); // List all partner preferences
    Route::post('/', [PhotoController::class, 'store']); // Create new partner preference
    Route::get('/{id}', [PhotoController::class, 'show']); // View single partner preference
    Route::post('/{id}', [PhotoController::class, 'update']); // Full update
    Route::delete('/{id}', [PhotoController::class, 'destroy']); // Delete partner preference
});
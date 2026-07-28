<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Astronomic\AstronomicInformationController;

Route::prefix('astronomic')->group(function () {

    Route::get('/', [AstronomicInformationController::class, 'index']);       // List all astronomic info (optional)
    Route::post('/', [AstronomicInformationController::class, 'store']);      // Create astronomic info

    Route::get('/{id}', [AstronomicInformationController::class, 'show']);    // View single astronomic info
    Route::post('/{id}', [AstronomicInformationController::class, 'update']); // Update astronomic info
    Route::delete('/{id}', [AstronomicInformationController::class, 'destroy']); // Delete astronomic info

    // Get astronomic info by profile ID
    Route::get('/profile/{profileId}', [AstronomicInformationController::class, 'byProfile']);
});
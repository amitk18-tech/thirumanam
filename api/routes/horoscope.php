<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Horoscope\HoroscopeController;

Route::prefix('horoscope')->group(function () {

    // Create one horoscope box
    Route::post('/', [HoroscopeController::class, 'store']);

    // Update one box
    Route::post('/{id}', [HoroscopeController::class, 'update']);

    // Get all 12 boxes for authenticated user
    Route::get('/my-boxes', [HoroscopeController::class, 'myBoxes']);

    // Delete a box
    Route::delete('/{id}', [HoroscopeController::class, 'destroy']);
});
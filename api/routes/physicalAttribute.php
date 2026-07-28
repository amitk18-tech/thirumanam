<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Profile\PhysicalAttributeController;


Route::prefix('physical-attribute')->group(function () {

    Route::get('/', [PhysicalAttributeController::class, 'index']); // List all partner preferences
    Route::post('/', [PhysicalAttributeController::class, 'store']); // Create new partner preference
    Route::get('/{id}', [PhysicalAttributeController::class, 'show']); // View single partner preference
    Route::post('/{id}', [PhysicalAttributeController::class, 'update']); // Full update
    Route::delete('/{id}', [PhysicalAttributeController::class, 'destroy']); // Delete partner preference
}); 
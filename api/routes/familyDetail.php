<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Profile\FamilyDetailController;


Route::prefix('family-detail')->group(function () {
    // 🔍 Custom routes
    // Route::get('/with-category', [CustomerController::class, 'withCategory']);
    // Route::get('/in-stock', [CustomerController::class, 'inStock']);
    // Route::get('/search', [CustomerController::class, 'search']);

    // 🔁 Bulk operations
    Route::post('/bulk-delete', [FamilyDetailController::class, 'bulkDelete']);
    Route::post('/bulk-update', [FamilyDetailController::class, 'bulkUpdate']);

    // 🧾 Standard CRUD routes
    Route::get('/', [FamilyDetailController::class, 'index']);           // List all products
    Route::post('/', [FamilyDetailController::class, 'store']);          // Create new product
    Route::get('/{id}', [FamilyDetailController::class, 'show']);        // View single product
    Route::post('/{id}', [FamilyDetailController::class, 'update']);      // Full update
    // Route::patch('/{id}', [FamilyDetailController::class, 'update']);    // Partial update
    Route::delete('/{id}', [FamilyDetailController::class, 'destroy']);  // Delete product
});
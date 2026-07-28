<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Rbac\RoleController;


// 'has.tenant'
Route::prefix('roles')->group(function () {


    // 🔁 Bulk operations
    Route::post('/bulk-delete', [RoleController::class, 'bulkDelete']);
    Route::post('/bulk-update', [RoleController::class, 'bulkUpdate']);

    // 🧾 Standard CRUD routes
    Route::get('/', [RoleController::class, 'index']);           // List all products
    Route::post('/', [RoleController::class, 'store']);          // Create new product
    Route::get('/{id}', [RoleController::class, 'show']);        // View single product
    Route::post('/{id}', [RoleController::class, 'update']);      // Full update
    Route::delete('/{id}', [RoleController::class, 'destroy']);  // Delete product
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Rbac\RolePermissionController;

Route::prefix('role-permissions')->group(function () {

    Route::get('/', [RolePermissionController::class, 'index']);           // List all products
    Route::post('/', [RolePermissionController::class, 'store']);          // Create new product
    Route::get('/{id}', [RolePermissionController::class, 'show']);        // View single product
    Route::post('/{id}', [RolePermissionController::class, 'update']);      // Full update
    // Route::patch('/{id}', [RolePermissionController::class, 'update']);    // Partial update
    Route::delete('/{id}', [RolePermissionController::class, 'destroy']);  // Delete product
});
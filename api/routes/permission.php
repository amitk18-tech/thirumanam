<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Rbac\PermissionController;

// 'has.tenant'
Route::prefix('permissions')->group(function () {

    Route::get('/', [PermissionController::class, 'index']);           // List all products
    Route::get('/{id}', [PermissionController::class, 'show']);        // View single product

});
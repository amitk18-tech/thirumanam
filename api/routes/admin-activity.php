<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Activity\AdminActivityController;

Route::prefix('admin-activity')->group(function () {
    Route::get('/', [AdminActivityController::class, 'index']);
    Route::post('/', [AdminActivityController::class, 'store']);
    Route::get('/{id}', [AdminActivityController::class, 'show']);
    Route::post('/{id}', [AdminActivityController::class, 'update']);
    Route::delete('/{id}', [AdminActivityController::class, 'destroy']);
});
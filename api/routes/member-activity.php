<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Activity\MemberActivityController;

Route::prefix('member-activity')->group(function () {
    Route::get('/', [MemberActivityController::class, 'index']);
    Route::post('/', [MemberActivityController::class, 'store']);
    Route::get('/{id}', [MemberActivityController::class, 'show']);
    Route::post('/{id}', [MemberActivityController::class, 'update']);
    Route::delete('/{id}', [MemberActivityController::class, 'destroy']);
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Profile\AddressController;


Route::prefix('address')->group(function () {
    
    Route::post('/', [AddressController::class, 'store']);
    Route::post('/{id}', [AddressController::class, 'update']);
    Route::get('/profile/{profileId}', [AddressController::class, 'byProfile']);
    Route::delete('/{id}', [AddressController::class, 'destroy']);
    
});
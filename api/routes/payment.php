<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payment\PaymentController;



Route::middleware('auth:sanctum')->group(function () {
    Route::post('/payment/create-order', [PaymentController::class, 'createOrder']);
    Route::post('/payment/verify', [PaymentController::class, 'verify']);
});

Route::prefix('payment')->group(function () {
    Route::get('', [PaymentController::class, 'index']);
});

// Route::post('/razorpay/verify', [PaymentController::class, 'verifyPayment']);
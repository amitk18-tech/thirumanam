<?php

use Illuminate\Support\Facades\Route;
use Bits\Package\Controllers\InvoiceController;
use Bits\Package\Controllers\InvoiceSettingController;
use Bits\Package\Controllers\RazorpayController;

Route::middleware(['auth:sanctum'])->group(function () {

    // 🧾 Invoices
    Route::apiResource('bits-invoices', InvoiceController::class);
    Route::get('bits-invoices/{id}/print', [InvoiceController::class, 'print']);
    Route::get('bits-invoices/{id}/download', [InvoiceController::class, 'downloadPdf']);

    // ⚙ Invoice Settings
    Route::get('bits-invoice-settings', [InvoiceSettingController::class, 'show']);
    Route::post('bits-invoice-settings', [InvoiceSettingController::class, 'update']);

    Route::prefix('api')
        ->middleware(['auth:sanctum'])
        ->group(function () {

            // 💳 Razorpay Payments
            Route::prefix('payments/razorpay')->group(function () {
                Route::post('create-order', [RazorpayController::class, 'createOrder']);
                Route::post('verify', [RazorpayController::class, 'verifyPayment']);
            });
        });
});

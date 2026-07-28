<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Chat\MessageController;



Route::prefix('message')->middleware('auth:sanctum')->group(function () {

    Route::post('/send-message', [MessageController::class, 'sendMessage']);

    // 🔁 Polling inbox (auth user)
    Route::get('/get-message', [MessageController::class, 'getReceiverMessages']);
    Route::get('/unread-count', [MessageController::class, 'unreadCount']);

    // 💬 Chat window
    Route::post('/chat-window', [MessageController::class, 'chatWindowMessages']);

});

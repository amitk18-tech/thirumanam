<?php

use Illuminate\Support\Facades\Route;
use Bits\Package\Controllers\DocsController;

Route::prefix('docs')->group(function () {
    Route::get('/repository', [DocsController::class, 'index']);
});
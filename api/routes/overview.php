<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\OverviewController;



Route::get('/overview', [OverviewController::class, 'overview']);

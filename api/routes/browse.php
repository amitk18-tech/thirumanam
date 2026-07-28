<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Member\BrowseMembersController;

Route::get('/browse-members', [BrowseMembersController::class, 'index']);
Route::get('/browse-members/me', [BrowseMembersController::class, 'showMe']);
Route::get('/browse-members/{id}', [BrowseMembersController::class, 'show']);

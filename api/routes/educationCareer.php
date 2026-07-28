<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Profile\EducationCareerController;


Route::prefix('education-career')->group(function () {
    Route::post('/', [EducationCareerController::class, 'store']);
    Route::post('/{id}', [EducationCareerController::class, 'update']);
    Route::get('/profile/{profileId}', [EducationCareerController::class, 'byProfile']);
    Route::delete('/{id}', [EducationCareerController::class, 'destroy']);
});
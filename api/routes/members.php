<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\Member\DeletedMemberController;

Route::prefix('members')->group(function () {

    Route::post('/change-password', [MemberController::class, 'changePassword']);
    Route::post('/deactivate-self', [MemberController::class, 'deactivateSelf']);
    Route::post('/admin/reactivate/{id}', [MemberController::class, 'adminReactivateMember']);

    // Deleted Member Actions
    Route::post('/restore/{id}', [DeletedMemberController::class, 'restore']);
    Route::delete('/force-delete/{id}', [DeletedMemberController::class, 'destroy']);

    // FIXED — now points to correct controller





    // Other CRUD routes
    Route::get('/delete-member-list', [MemberController::class, 'deleteMemberList']);
    Route::get('/', [MemberController::class, 'index']);
    Route::get('/filter-by-savaran', [MemberController::class, 'getAllFilterMemberBySavaran']);
    Route::get('/filtered-member-details/{id}', [MemberController::class, 'getFilteredMemberDetails']);
    Route::post('/update-savaran', [MemberController::class, 'updateSavaran']);

    Route::get('/me', [MemberController::class, 'getCurrentUserProfile']);
    Route::get('/registrationMode/online', [MemberController::class, 'getByRegistrationMode']);
    Route::get('/old-id-renewed-members', [MemberController::class, 'oldIdRenewedMembers']);
    Route::get('/pending-renewal-members', [MemberController::class, 'pendingRenewalMembers']);
    Route::get('/search-reports', [MemberController::class, 'searchReport']);
    Route::get('/incomplete', [MemberController::class, 'incompleteMembers']);

    Route::post('/', [MemberController::class, 'store']);
    Route::get('/{id}', [MemberController::class, 'show']);
    Route::get('/admin/{id}', [MemberController::class, 'adminGetById']);
    Route::post('/admin/print', [MemberController::class, 'adminPrint']);

    Route::post('/check-mobile-number', [MemberController::class, 'checkMobileNumber']);

    Route::post('/{id}', [MemberController::class, 'update']);
    Route::delete('/{id}', [MemberController::class, 'destroy']);

    Route::post('/block/{id}', [MemberController::class, 'blockMember']);
    Route::post('/unblock/{id}', [MemberController::class, 'unblockMember']);
    Route::post('/verify/{id}', [MemberController::class, 'verifyMember']);
    Route::post('/reject/{id}', [MemberController::class, 'rejectMember']);

    Route::post('/renew/{id}', [MemberController::class, 'renewMembership']);


    Route::post('/activate/{id}', [MemberController::class, 'activateMember']);

    Route::post('/set-matched/{id}', [MemberController::class, 'matchedMembers']);

    Route::post('/reduce-profile-allowed-count', [MemberController::class, 'reduceProfileAllowedCount']);

    Route::post('/reduce-send-interest', [MemberController::class, 'reduceSendInterest']);

    Route::get('/full-profile/{id}', [MemberController::class, 'showFullProfile']);

    Route::get('/mobile-pdf-download/{id}', [MemberController::class, 'mobilePdfDownload']);
});
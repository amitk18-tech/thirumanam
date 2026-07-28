<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Setup\SetupController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Memberships\PaymentController;
use App\Http\Controllers\Filter\FilterController;
use App\Http\Controllers\Activity\MemberActivityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Sms\SmsGatewayHubController;
use App\Http\Controllers\Notifications\NotificationController;



require __DIR__ . '/channels.php';
require __DIR__ . '/console.php';



Route::post('/auth/user/login', [AuthController::class, 'login']);
Route::post('/auth/login', [AuthController::class, 'adminLogin']);

// 1. Initially user requests OTP
Route::post('/setup/request-otp', [SetupController::class, 'requestOtp']);
// 2. User verifies OTP and gets a temporary setup token
Route::post('/setup/verify-otp', [SetupController::class, 'verifyOtp']);
// 3. User completes setup with details
Route::post('/setup/complete', [SmsGatewayHubController::class, 'completeSetup']);

Route::post('setup/reset-password', [SmsGatewayHubController::class, 'resetPassword']);


Route::get('/filter', [FilterController::class, 'filter']);

// Route::post('/create-order', [PaymentController::class, 'createOrder']);
//   Route::post('/verify', [PaymentController::class, 'verifyPayment']); 


Route::get('/member-activities', [MemberActivityController::class, 'index']);



require __DIR__ . '/payment.php';

Route::post('/send-sms', [SmsGatewayHubController::class, 'send']);
Route::post('/verify-sms', [SmsGatewayHubController::class, 'verify']);

// Public membership listing
Route::get('/membership', [App\Http\Controllers\Memberships\MembershipController::class, 'publicIndex']);


// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    require __DIR__ . '/profile.php';
    require __DIR__ . '/user.php';
    require __DIR__ . '/partnerPreference.php';
    require __DIR__ . '/profileVerification.php';
    require __DIR__ . '/membership.php';
    require __DIR__ . '/photo.php';
    require __DIR__ . '/familyDetail.php';
    require __DIR__ . '/matchAction.php';
    require __DIR__ . '/profileInteraction.php';
    require __DIR__ . '/message.php';
    require __DIR__ . '/role.php';
    require __DIR__ . '/permission.php';
    require __DIR__ . '/rolePermission.php';
    require __DIR__ . '/members.php';
    require __DIR__ . '/matrimony.php';
    require __DIR__ . '/overview.php';
    require __DIR__ . '/astronomic.php';
    require __DIR__ . '/horoscope.php';
    require __DIR__ . '/physicalAttribute.php';
    require __DIR__ . '/address.php';
    require __DIR__ . '/member-activity.php';
    require __DIR__ . '/admin-activity.php';
    require __DIR__ . '/browse.php';
    require __DIR__ . '/payment.php';


    Route::get('/home-page-data', [HomeController::class, 'homePageData']);
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/count', [NotificationController::class, 'unreadCount']);

    Route::resource('staffs', \App\Http\Controllers\Rbac\StaffController::class);
});


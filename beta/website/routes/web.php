<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PlansController;

Route::get('/', [HomeController::class, 'index']);

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login/select-profile', [AuthController::class, 'showSelectProfile'])->name('login.select');
Route::post('/login/select-profile', [AuthController::class, 'submitSelectProfile']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Registration routes (public — OTP flow + profile setup for new users)
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register/send-otp', [RegisterController::class, 'sendOtp']);
Route::post('/register/verify-otp', [RegisterController::class, 'verifyOtp']);
Route::post('/register/complete', [RegisterController::class, 'complete']);
Route::get('/register/profile', [RegisterController::class, 'showProfileSetup']);
Route::post('/register/profile', [RegisterController::class, 'saveProfile']);

// Public routes

Route::get('/contact', function() { return view('contact'); });
Route::get('/faq', function() {
    $faqs = require resource_path('views/pages/faq_data.php');
    return view('pages.faq', [
        'generalFaqs' => $faqs['general'],
        'onlineFaqs'  => $faqs['online'],
        'offlineFaqs' => $faqs['offline'],
    ]);
})->name('faq');
Route::get('/privacy', function() { return view('pages.privacy'); })->name('privacy');
Route::get('/terms', function() { return view('pages.terms'); })->name('terms');
Route::get('/plans', [\App\Http\Controllers\PlansController::class, 'index'])->name('plans.index');

// Protected routes
Route::middleware('auth.session')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/members', [MemberController::class, 'index'])->name('members.index');
    Route::get('/members/{id}', [MemberController::class, 'show'])->name('members.show');
    Route::post('/members/{id}/interest', [MemberController::class, 'sendInterest'])->name('members.interest');
    Route::post('/members/{id}/shortlist', [MemberController::class, 'shortlist'])->name('members.shortlist');
    Route::post('/members/{id}/block', [MemberController::class, 'block'])->name('members.block');
    Route::get('/interests', [InterestController::class, 'index'])->name('interests.index');
    Route::get('/profile/me', [ProfileController::class, 'me'])->name('profile.me');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/horoscope/save-batch', [ProfileController::class, 'saveHoroscopeBatch'])->name('horoscope.batch');
    Route::post('/photo/upload', [ProfileController::class, 'uploadPhoto'])->name('photo.upload');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages/chat', [MessageController::class, 'chatWindow'])->name('messages.chat');
    Route::post('/messages/send', [MessageController::class, 'send'])->name('messages.send');
    Route::get('/messages/unread', [MessageController::class, 'unreadCount'])->name('messages.unread');
    Route::post('/profile/deactivate', [ProfileController::class, 'deactivate'])->name('profile.deactivate');
    Route::post('/members/{id}/follow', [MemberController::class, 'follow'])->name('members.follow');
    Route::post('/members/{id}/report', [MemberController::class, 'report'])->name('members.report');
    Route::get('/shortlisted', [MemberController::class, 'shortlisted'])->name('shortlisted.index');
    Route::get("/notifications", [App\Http\Controllers\NotificationController::class, "index"])->name("notifications.index");
});

Route::get('/debug-members', function () {
    $api = app(\App\Services\ApiService::class);
    $response = $api->authGet('members', ['per_page' => 12, 'page' => 1]);
    return response()->json($response);
});

Route::get('/debug-token', function () {
    return response()->json([
        'token' => session('api_token'),
        'user' => session('api_user'),
    ]);
});

// Payment routes

Route::middleware('auth.session')->group(function () {
    
    Route::get('/payment', [\App\Http\Controllers\PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/verify', [\App\Http\Controllers\PaymentController::class, 'verify'])->name('payment.verify');
    Route::get('/payment/success', [\App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/failed', [\App\Http\Controllers\PaymentController::class, 'failed'])->name('payment.failed');
});

// Plans + Payment (auth required)
Route::middleware('auth.session')->group(function () {
    
});

Route::get('/debug-dashboard', function() {
    $api = app(\App\Services\ApiService::class);
    $me = $api->authGet('members/me');
    return response()->json([
        'photo' => $me['data']['profile_photo'] ?? 'NOT FOUND',
        'interests_sent' => $me['data']['interests_sent_count'] ?? 'NOT FOUND',
    ]);
});

// Forgot password flow
Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showPhone']);
Route::post('/forgot-password/send-otp', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendOtp']);
Route::get('/forgot-password/verify', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showVerify']);
Route::post('/forgot-password/verify-otp', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'verifyOtp']);
Route::get('/forgot-password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showReset']);
Route::post('/forgot-password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'resetPassword']);

// Contact form POST
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');

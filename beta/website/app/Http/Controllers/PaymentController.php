<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

class PaymentController extends Controller
{
    protected $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function show(Request $request)
    {
        $membershipId = $request->query('membership_id');
        if (!$membershipId) {
            return redirect()->route('plans.index')->with('error', 'Please select a plan.');
        }

        // Fetch membership details (auth required)
        $response = $this->api->authGet("membership/{$membershipId}");
        $plan = $response['data'] ?? null;

        if (!$plan || ($plan['price'] ?? 0) <= 0) {
            return redirect()->route('plans.index')->with('error', 'Invalid plan selected.');
        }

        // Create Razorpay order via API
        $orderResponse = $this->api->authPost('payment/create-order', [
            'membership_id' => $membershipId,
        ]);

        if (!($orderResponse['success'] ?? false)) {
            $errorMsg = $orderResponse['message'] ?? 'Could not initiate payment. Please try again.';
            return redirect()->route('plans.index')->with('error', $errorMsg);
        }

        $order = $orderResponse['data']['order'];
        $razorpayKey = $orderResponse['data']['key'];
        $user = session('api_user');

        return view('payment', [
            'plan'         => $plan,
            'order'        => $order,
            'razorpayKey'  => $razorpayKey,
            'membershipId' => $membershipId,
            'user'         => $user,
        ]);
    }

    public function verify(Request $request)
    {
        $response = $this->api->authPost('payment/verify', [
            'razorpay_order_id'   => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature'  => $request->razorpay_signature,
            'membership_id'       => $request->membership_id,
        ]);

        $success = $response['data']['success'] ?? false;

        if ($success) {
            $memberResponse = $this->api->authGet('members/me');
            if (!empty($memberResponse['data'])) {
                $currentUser = session('api_user', []);
                session(['api_user' => array_merge($currentUser, $memberResponse['data'])]);
            }
            return redirect()->route('payment.success')->with('plan_name', $request->plan_name ?? 'your plan');
        }

        return redirect()->route('payment.failed')->with('error', $response['data']['message'] ?? 'Payment verification failed.');
    }

    public function success()
    {
        return view('payment-success');
    }

    public function failed()
    {
        return view('payment-failed');
    }
}

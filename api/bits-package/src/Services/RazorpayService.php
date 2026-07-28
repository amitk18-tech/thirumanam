<?php

namespace Bits\Package\Services;

use Razorpay\Api\Api;

class RazorpayService
{
    protected Api $api;

    public function __construct()
    {
        $this->api = new Api(
            config('razorpay.key'),
            config('razorpay.secret')
        );
    }

    /**
     * 🔹 Create Razorpay Order (Payment Intent)
     */
     public function createOrder(int $amount, string $receipt): array
    {
        $order = $this->api->order->create([
            'receipt' => $receipt,
            'amount' => $amount * 100, // INR → paise
            'currency' => 'INR',
            'payment_capture' => 1,
        ]);

        return $order->toArray(); // ✅ THIS IS THE FIX
    }

    /**
     * 🔐 Verify Razorpay payment signature
     */
    public function verifySignature(array $data): void
    {
        $this->api->utility->verifyPaymentSignature($data);
    }
}
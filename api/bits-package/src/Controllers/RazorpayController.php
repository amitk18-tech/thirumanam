<?php

namespace Bits\Package\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Razorpay\Api\Errors\SignatureVerificationError;
use Bits\Package\Services\RazorpayService;
use Bits\Payment\Events\PaymentSuccessful;
use Bits\Payment\Events\PaymentFailed;
use Bits\Package\Models\Payment;

class RazorpayController extends Controller
{
    public function __construct(
        protected RazorpayService $razorpay
    ) {}

    /**
     * 1️⃣ CREATE ORDER
     */
    public function createOrder(Request $request)
    {
        $request->validate([
            'amount'          => 'required|numeric|min:1',
            'gateway'         => 'required|string|in:razorpay',
            'reference_type'  => 'nullable|string|max:50',
            'reference_id'    => 'nullable|string|max:100',
        ]);

        $payment = Payment::create([
            'user_id'        => auth()->id(),
            'amount'         => $request->amount,
            'status'         => 'initiated',
            'gateway'        => $request->gateway,
            'reference_type' => $request->reference_type,
            'reference_id'   => $request->reference_id,
        ]);

        $receipt = $request->reference_type
            ? $request->reference_type . '_' . $request->reference_id
            : 'payment_' . $payment->id;

        $razorpayOrder = $this->razorpay->createOrder(
            $request->amount,
            $receipt
        );

        $payment->update([
            'transaction_id' => $razorpayOrder['id'],
        ]);

        return response()->json([
            'success' => true,
            'order'   => $razorpayOrder,
            'key'     => config('razorpay.key'),
        ]);
    }

    /**
     * 2️⃣ VERIFY PAYMENT
     */
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'razorpay_order_id'   => 'required|string',
            'razorpay_payment_id' => 'nullable|string',
            'razorpay_signature'  => 'nullable|string',
        ]);

        $payment = Payment::where(
            'transaction_id',
            $request->razorpay_order_id
        )->first();

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not found',
            ], 404);
        }

        // ❌ Cancelled
        if (
            empty($request->razorpay_payment_id) ||
            empty($request->razorpay_signature)
        ) {
            $payment->update(['status' => 'failed']);

            event(new PaymentFailed(
                $payment->id,
                'cancelled'
            ));

            return response()->json([
                'success' => false,
                'message' => 'Payment cancelled',
            ]);
        }

        try {
            $this->razorpay->verifySignature([
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ]);

            $payment->update([
                'status'         => 'confirmed',
                'paid_at'        => now(),
                'payment_method' => 'razorpay',
            ]);

            event(new PaymentSuccessful(
                $payment->id,                      // paymentId
                $request->razorpay_payment_id,     // transactionId
                'razorpay'                         // gateway (optional)
            ));


            return response()->json([
                'success' => true,
                'message' => 'Payment verified',
            ]);
        } catch (SignatureVerificationError $e) {

            $payment->update(['status' => 'failed']);

            event(new PaymentFailed(
                $payment->id,
                'invalid_signature'
            ));

            return response()->json([
                'success' => false,
                'message' => 'Invalid signature',
            ], 400);
        }
    }
}
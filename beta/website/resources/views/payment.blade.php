@extends('layouts.app')

@section('title', 'Payment — Thirumanam')

@section('content')
<div class="min-h-screen bg-rose-50 py-12 px-4">
    <div class="max-w-lg mx-auto">

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-primary">Complete Your Payment</h1>
            <p class="text-gray-500 text-sm mt-1">Secure payment via Razorpay</p>
        </div>

        {{-- Order Summary --}}
        <div class="bg-white rounded-2xl shadow-md p-6 mb-6">
            <h2 class="font-semibold text-gray-700 mb-4 text-lg">Order Summary</h2>
            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                <span class="text-gray-500">Plan</span>
                <span class="font-semibold text-primary">{{ $plan['name'] }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                <span class="text-gray-500">Validity</span>
                <span class="font-semibold">6 Months</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                <span class="text-gray-500">Profile Views</span>
                <span class="font-semibold">{{ $plan['profiles_view_allowed'] }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                <span class="text-gray-500">Interests</span>
                <span class="font-semibold">{{ $plan['sent_interest_allowed'] }}</span>
            </div>
            <div class="flex justify-between items-center py-3 mt-2">
                <span class="font-bold text-gray-700 text-lg">Total</span>
                <span class="font-extrabold text-primary text-2xl">₹{{ number_format($plan['price']) }}</span>
            </div>
        </div>

        {{-- Pay Button --}}
        <button id="rzp-button" style="background-color:#8B1A1A;color:white;width:100%;padding:1rem;border-radius:0.75rem;font-size:1.125rem;font-weight:700;border:none;cursor:pointer;"
            class="w-full bg-rose-500 hover:bg-rose-600 text-white font-bold py-4 rounded-xl text-lg transition shadow-md">
            Pay ₹{{ number_format($plan['price']) }} Securely
        </button>

        <p class="text-center text-gray-400 text-xs mt-4">
            🔒 Powered by Razorpay. Your payment info is never stored on our servers.
        </p>

        {{-- Hidden verify form --}}
        <form id="verify-form" action="{{ route('payment.verify') }}" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
            <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
            <input type="hidden" name="razorpay_signature" id="razorpay_signature">
            <input type="hidden" name="membership_id" value="{{ $membershipId }}">
            <input type="hidden" name="plan_name" value="{{ $plan['name'] }}">
        </form>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        key: "{{ $razorpayKey }}",
        amount: "{{ $order['amount'] }}",
        currency: "{{ $order['currency'] }}",
        name: "Thirumanam",
        description: "{{ $plan['name'] }} Membership",
        order_id: "{{ $order['id'] }}",
        prefill: {
            name: "{{ $user['name'] ?? '' }}",
            contact: "{{ $user['phone'] ?? '' }}"
        },
        theme: {
            color: "#8B1A1A"
        },
        handler: function (response) {
            document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('razorpay_signature').value = response.razorpay_signature;
            document.getElementById('verify-form').submit();
        },
        modal: {
            ondismiss: function() {
                // User closed modal — stay on page
            }
        }
    };

    document.getElementById('rzp-button').onclick = function(e) {
        var rzp = new Razorpay(options);
        rzp.open();
        e.preventDefault();
    };
</script>
@endsection

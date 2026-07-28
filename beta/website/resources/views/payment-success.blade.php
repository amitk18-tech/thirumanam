@extends('layouts.app')

@section('title', 'Payment Successful — Thirumanam')

@section('content')
<div class="min-h-screen bg-rose-50 flex items-center justify-center px-4">
    <div class="bg-white rounded-2xl shadow-md p-10 max-w-md w-full text-center">
        <div class="text-6xl mb-4">🎉</div>
        <h1 class="text-2xl font-bold text-green-600 mb-2">Payment Successful!</h1>
        <p class="text-gray-500 mb-2">Your <strong>{{ session('plan_name', 'membership') }}</strong> plan is now active.</p>
        <p class="text-gray-400 text-sm mb-8">Your permanent member ID has been generated. You can now browse profiles and connect with matches.</p>
        <a href="{{ url('/members') }}"
           class="block bg-primary hover:bg-red-900 text-white font-semibold py-3 rounded-xl transition mb-3">
            Browse Members
        </a>
        <a href="{{ url('/dashboard') }}"
           class="block bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition">
            Go to Dashboard
        </a>
    </div>
</div>
@endsection

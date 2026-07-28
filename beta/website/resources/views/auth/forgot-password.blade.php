@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">

        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="text-3xl font-bold text-primary">திருமணம்</a>
            <p class="text-gray-500 mt-2">Reset your password</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            @if($errors->has('mobile'))
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-6 text-sm">
                    {{ $errors->first('mobile') }}
                </div>
            @endif

            <p class="text-sm text-gray-500 mb-6">Enter your registered mobile number. We'll send you an OTP to reset your password.</p>

            <form method="POST" action="{{ url('/forgot-password/send-otp') }}">
                @csrf
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mobile Number</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <i class="fas fa-phone-alt"></i>
                        </span>
                        <input type="text" name="mobile" value="{{ old('mobile') }}"
                            placeholder="Enter your mobile number"
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm"
                            required>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-red-900 transition text-sm">
                    Send OTP
                </button>

                <div class="mt-4 text-center text-sm text-gray-500">
                    <a href="{{ url('/login') }}" class="text-primary hover:underline">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

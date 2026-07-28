@extends('layouts.app')

@section('title', 'Verify OTP')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">

        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="text-3xl font-bold text-primary">திருமணம்</a>
            <p class="text-gray-500 mt-2">Enter the OTP sent to your mobile</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            @if($errors->has('otp'))
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-6 text-sm">
                    {{ $errors->first('otp') }}
                </div>
            @endif

            <p class="text-sm text-gray-500 mb-6">An OTP has been sent to <strong>{{ session('fp_mobile') }}</strong>. Enter it below.</p>

            <form method="POST" action="{{ url('/forgot-password/verify-otp') }}">
                @csrf
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">OTP</label>
                    <input type="text" name="otp" placeholder="Enter 6-digit OTP"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm tracking-widest"
                        maxlength="6" required>
                </div>

                <button type="submit"
                    class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-red-900 transition text-sm">
                    Verify OTP
                </button>

                <div class="mt-4 text-center text-sm text-gray-500">
                    <a href="{{ url('/forgot-password') }}" class="text-primary hover:underline">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

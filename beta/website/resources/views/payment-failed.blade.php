@extends('layouts.app')

@section('title', __('ui.pay_failed_title'))

@section('content')
<div class="min-h-screen bg-rose-50 flex items-center justify-center px-4">
    <div class="bg-white rounded-2xl shadow-md p-10 max-w-md w-full text-center">
        <div class="text-6xl mb-4">❌</div>
        <h1 class="text-2xl font-bold text-red-600 mb-2">{{ __('ui.pay_failed_heading') }}</h1>
        <p class="text-gray-500 mb-2">{{ session('error', __('ui.pay_failed_heading')) }}</p>
        <p class="text-gray-400 text-sm mb-8">{{ __('ui.pay_failed_note') }}</p>
        <a href="{{ url('/plans') }}"
           class="block bg-primary hover:bg-red-900 text-white font-semibold py-3 rounded-xl transition mb-3">
            {{ __('ui.pay_failed_retry_btn') }}
        </a>
        <a href="{{ url('/dashboard') }}"
           class="block bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition">
            {{ __('ui.pay_failed_dashboard_btn') }}
        </a>
    </div>
</div>
@endsection

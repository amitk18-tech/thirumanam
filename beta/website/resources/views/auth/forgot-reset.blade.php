@extends('layouts.app')

@section('title', __('ui.fp_reset_title'))

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">

        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="text-3xl font-bold text-primary">திருமணம்</a>
            <p class="text-gray-500 mt-2">{{ __('ui.fp_reset_subtitle') }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            @if($errors->has('password'))
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-6 text-sm">
                    {{ $errors->first('password') }}
                </div>
            @endif

            <form method="POST" action="{{ url('/forgot-password/reset') }}" x-data="{ showPw: false, showConfirm: false }">
                @csrf

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.fp_gender_label') }}</label>
                    <select name="gender" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm" required>
                        <option value="">{{ __('ui.fp_gender_placeholder') }}</option>
                        <option value="male">{{ __('ui.fp_gender_male') }}</option>
                        <option value="female">{{ __('ui.fp_gender_female') }}</option>
                    </select>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.fp_new_password') }}</label>
                    <div class="relative">
                        <input :type="showPw ? 'text' : 'password'" name="password"
                            placeholder="{{ __('ui.fp_new_password_ph') }}"
                            class="w-full px-4 pr-10 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm"
                            required>
                        <button type="button" @click="showPw = !showPw"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i :class="showPw ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.fp_confirm_password') }}</label>
                    <div class="relative">
                        <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation"
                            placeholder="{{ __('ui.fp_confirm_password_ph') }}"
                            class="w-full px-4 pr-10 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm"
                            required>
                        <button type="button" @click="showConfirm = !showConfirm"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i :class="showConfirm ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-red-900 transition text-sm">
                    {{ __('ui.fp_reset_btn') }}
                </button>

                <div class="mt-4 text-center text-sm text-gray-500">
                    <a href="{{ url('/login') }}" class="text-primary hover:underline">{{ __('ui.fp_back_to_login') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

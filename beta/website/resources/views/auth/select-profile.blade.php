@extends('layouts.app')

@section('title', __('ui.sp_title'))

@section('content')
<div class="min-h-screen bg-rose-50 flex items-center justify-center px-4">
    <div class="bg-white rounded-2xl shadow-md p-8 max-w-md w-full">

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-primary">{{ __('ui.sp_title') }}</h1>
            <p class="text-gray-500 text-sm mt-1">{{ __('ui.sp_subtitle') }}</p>
        </div>

        @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
            {{ $errors->first() }}
        </div>
        @endif

        <form action="/login/select-profile" method="POST" class="space-y-4">
            @csrf
            @foreach($profiles as $profile)
            <label class="flex items-center gap-4 border-2 border-gray-100 hover:border-primary rounded-xl p-4 cursor-pointer transition">
                <input type="radio" name="gender" value="{{ $profile['gender'] }}" class="accent-primary w-4 h-4" required>
                <div class="flex items-center gap-3 flex-1">
                    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                        <i class="fas fa-{{ $profile['gender'] === 'male' ? 'male' : 'female' }} text-primary"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">{{ $profile['name'] }}</p>
                        <p class="text-sm text-gray-400">{{ ucfirst($profile['gender']) }} {{ __('ui.sp_profile_label') }}</p>
                    </div>
                </div>
            </label>
            @endforeach

            <button type="submit"
                class="w-full bg-primary hover:bg-red-900 text-white font-semibold py-3 rounded-xl transition mt-4">
                {{ __('ui.sp_continue') }}
            </button>
        </form>

        <p class="text-center text-sm text-gray-400 mt-4">
            <a href="/login" class="text-primary hover:underline">{{ __('ui.sp_back_to_login') }}</a>
        </p>
    </div>
</div>
@endsection

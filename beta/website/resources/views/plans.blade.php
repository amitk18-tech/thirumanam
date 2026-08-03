@extends('layouts.app')

@section('title', __('ui.plans_title'))

@section('content')
<div class="min-h-screen bg-rose-50 py-12 px-4">
    <div class="max-w-5xl mx-auto">

        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-primary mb-2">{{ __('ui.plans_title') }}</h1>
            <p class="text-gray-500">{{ __('ui.plans_subtitle') }}</p>
        </div>

        @if(session('error'))
        <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg text-center">
            {{ session('error') }}
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($plans as $plan)
            @php
                $isCurrent   = $plan['slug'] === $currentSlug;
                $planLevel   = $hierarchy[$plan['slug']] ?? 0;
                $isDowngrade = $planLevel < $currentLevel;
                $isDisabled  = $isCurrent || $isDowngrade;
                $icons       = ['essential' => '⭐', 'classic' => '💎', 'prime' => '👑'];
                $icon        = $icons[$plan['slug']] ?? '⭐';
            @endphp

            <div class="bg-white rounded-2xl shadow-md border-2 {{ $isCurrent ? 'border-green-400' : 'border-gray-100' }} p-6 flex flex-col {{ $isDisabled ? 'opacity-60' : '' }}">

                <div class="text-4xl text-center mb-3">{{ $icon }}</div>
                <h2 class="text-xl font-bold text-center text-primary mb-1">{{ $plan['name'] }}</h2>
                <p class="text-center text-gray-400 text-sm mb-4">{{ __('ui.plans_validity') }}</p>

                <div class="text-center mb-6">
                    <span class="text-4xl font-extrabold text-primary">₹{{ number_format($plan['price']) }}</span>
                </div>

                <ul class="space-y-2 mb-6 flex-1">
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <span class="text-green-500">✓</span>
                        {{ __('ui.plans_view_profiles') }} <strong>{{ $plan['profiles_view_allowed'] }}</strong> {{ __('ui.plans_profiles') }}
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <span class="text-green-500">✓</span>
                        {{ __('ui.plans_send_interests') }} <strong>{{ $plan['sent_interest_allowed'] }}</strong> {{ __('ui.plans_interests') }}
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <span class="text-green-500">✓</span>
                        {{ __('ui.plans_send_interests') }} <strong>{{ $plan['messages_sent_allowed'] }}</strong> {{ __('ui.plans_messages') }}
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <span class="text-green-500">✓</span>
                        {{ __('ui.plans_validity') }}
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <span class="text-green-500">✓</span>
                        {{ $plan['soveran_show'] }}
                    </li>
                    </li>
                </ul>

                @if($isCurrent)
                <button disabled class="w-full text-center bg-green-100 text-green-700 font-semibold py-3 rounded-xl cursor-not-allowed">
                    {{ __('ui.plans_current') }}
                </button>
                @elseif($isDowngrade)
                <button disabled class="w-full text-center bg-gray-100 text-gray-400 font-semibold py-3 rounded-xl cursor-not-allowed">
                    {{ __('ui.plans_not_available') }}
                </button>
                @elseif($isLoggedIn)
                <a href="{{ url('/payment?membership_id=' . $plan['id']) }}"
                   class="block text-center bg-primary hover:bg-red-900 text-white font-semibold py-3 rounded-xl transition">
                    {{ __('ui.plans_get') }} {{ $plan['name'] }}
                </a>
                @else
                <a href="{{ route('login') }}"
                   class="block text-center bg-primary hover:bg-red-900 text-white font-semibold py-3 rounded-xl transition">
                    {{ __('ui.plans_login_upgrade') }}
                </a>
                @endif
            </div>
            @endforeach
        </div>

        <p class="text-center text-gray-400 text-xs mt-8">
            {{ __('ui.plans_footer') }}
        </p>
    </div>
</div>
@endsection

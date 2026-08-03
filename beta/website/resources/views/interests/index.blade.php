@extends('layouts.app')

@section('title', $tab === 'sent' ? __('ui.int_sent_tab') : __('ui.int_received_tab'))

@section('content')

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ __('ui.int_title') }}</h1>
                <p class="text-gray-500 text-sm mt-1">{{ __('ui.int_subtitle') }}</p>
            </div>
            <a href="{{ url('/dashboard') }}" class="text-sm text-primary hover:underline">{{ __('ui.int_back') }}</a>
        </div>

        {{-- Tabs --}}
        <div class="flex space-x-1 bg-white rounded-xl shadow-sm border border-gray-100 p-1 mb-6 w-fit">
            <a href="{{ url('/interests?tab=sent') }}"
               class="px-5 py-2 rounded-lg text-sm font-semibold transition {{ $tab === 'sent' ? 'bg-primary text-white' : 'text-gray-500 hover:text-gray-700' }}">
                <i class="fas fa-paper-plane mr-1"></i> {{ __('ui.int_sent_tab') }}
            </a>
            <a href="{{ url('/interests?tab=received') }}"
               class="px-5 py-2 rounded-lg text-sm font-semibold transition {{ $tab === 'received' ? 'bg-primary text-white' : 'text-gray-500 hover:text-gray-700' }}">
                <i class="fas fa-heart mr-1"></i> {{ __('ui.int_received_tab') }}
            </a>
        </div>

        {{-- List --}}
        @if(empty($interests))
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas {{ $tab === 'sent' ? 'fa-paper-plane' : 'fa-heart' }} text-primary text-2xl"></i>
                </div>
                <p class="text-gray-500 text-sm">{{ $tab === 'sent' ? __('ui.int_empty_sent') : __('ui.int_empty_received') }}</p>
                @if($tab === 'sent')
                <a href="{{ url('/members') }}" class="mt-4 inline-block bg-primary text-white text-sm font-semibold px-5 py-2 rounded-lg hover:bg-red-900 transition">
                    {{ __('ui.int_browse') }}
                </a>
                @endif
            </div>
        @else
            <div class="space-y-3">
                @foreach($interests as $interest)
                @php
                    $profile = $tab === 'sent'
                        ? ($interest['receiver'] ?? [])
                        : ($interest['sender'] ?? []);
                    $user    = $profile['user'] ?? [];
                    $member  = $profile['member'] ?? [];
                    $photo   = $profile['profile_photo'] ?? null;
                    $photoUrl = $photo
                        ? (str_starts_with($photo, 'http') ? $photo : 'https://api.thirumanam.info/' . $photo)
                        : null;
                    $name     = $user['name'] ?? __('ui.ms_unknown');
                    $profileId = $profile['id'] ?? null;
                    $memberNo = $member['member_no'] ?? null;
                    $status   = $interest['status'] ?? 'pending';
                    $statusColor = match($status) {
                        'accepted' => 'text-green-600 bg-green-50',
                        'rejected' => 'text-red-600 bg-red-50',
                        default    => 'text-amber-600 bg-amber-50',
                    };
                    $statusLabel = match($status) {
                        'accepted' => __('ui.int_status_accepted'),
                        'rejected' => __('ui.int_status_rejected'),
                        default    => __('ui.int_status_pending'),
                    };
                @endphp
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center space-x-4">
                    {{-- Photo --}}
                    <div class="w-14 h-14 rounded-full overflow-hidden border border-gray-200 flex-shrink-0">
                        @if($photoUrl)
                            <img src="{{ $photoUrl }}" alt="{{ $name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-red-50 flex items-center justify-center">
                                <i class="fas fa-user text-primary text-xl"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-800 truncate">{{ $name }}</p>
                        @if($memberNo)
                        <p class="text-xs text-gray-400 mt-0.5">ID: {{ $memberNo }}</p>
                        @endif
                        <p class="text-xs text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($interest['created_at'])->format('d M Y') }}</p>
                    </div>

                    {{-- Status --}}
                    <div class="flex items-center space-x-3 flex-shrink-0">
                        <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $statusColor }}">
                            {{ $statusLabel }}
                        </span>
                        @if($profileId)
                        <a href="{{ url('/members/' . $profileId) }}"
                           class="text-xs bg-primary text-white font-semibold px-3 py-1.5 rounded-lg hover:bg-red-900 transition">
                            {{ __('ui.int_view_profile') }}
                        </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif

    </div>
</div>

@endsection

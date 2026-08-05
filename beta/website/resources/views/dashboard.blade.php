@extends('layouts.app')

@section('title', __('ui.dash_title'))

@section('content')

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @php
            $photo = $member['profile']['profile_photo'] ?? null;
            $photoUrl = $photo
                ? (str_starts_with($photo, 'http') ? $photo : 'https://api.thirumanam.info/' . $photo)
                : null;
            $membershipType = tv('membership_type', $member['profile']['membership_type'] ?? 'default');
        @endphp

        {{-- Profile Completion --}}
        @if(!$member['is_profile_complete'])
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <i class="fas fa-exclamation-circle text-amber-500 text-lg"></i>
                <div>
                    <p class="text-amber-800 font-semibold text-sm">{{ __('ui.dash_incomplete_title') }}</p>
                    <p class="text-amber-600 text-xs">{{ __('ui.dash_incomplete_body') }}</p>
                </div>
            </div>
            <a href="{{ url('/profile/edit') }}" class="bg-amber-500 text-white text-xs font-semibold px-4 py-2 rounded-lg hover:bg-amber-600 transition">
                {{ __('ui.dash_complete_now') }}
            </a>
        </div>
        @endif

        {{-- Membership Expired --}}
        @if($member['membership_expired'])
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <i class="fas fa-clock text-red-500 text-lg"></i>
                <div>
                    <p class="text-red-800 font-semibold text-sm">{{ __('ui.dash_expired_title') }}</p>
                    <p class="text-red-600 text-xs">{{ __('ui.dash_expired_body') }}</p>
                </div>
            </div>
            <a href="{{ url('/plans') }}" class="bg-primary text-white text-xs font-semibold px-4 py-2 rounded-lg hover:bg-red-900 transition">
                {{ __('ui.dash_renew_now') }}
            </a>
        </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-6">

            {{-- LEFT SIDEBAR --}}
            <div class="w-full lg:w-72 flex-shrink-0 space-y-4">

                {{-- Profile Card --}}
                <div class="bg-primary rounded-2xl p-6 text-white text-center">
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white/30 mx-auto mb-3">
                        @if($photoUrl)
                            <img src="{{ $photoUrl }}" alt="Profile" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-white/20 flex items-center justify-center">
                                <i class="fas fa-user text-3xl"></i>
                            </div>
                        @endif
                    </div>
                    <h2 class="text-xl font-bold">{{ $member['name'] }}</h2>
                    <p class="text-red-200 text-sm mt-1">{{ $membershipType }} {{ __('ui.dash_member_suffix') }}</p>
                    <p class="text-red-200 text-xs mt-0.5">{{ __('ui.dash_id_prefix') }}: {{ $member['member_no'] ?? __('ui.dash_pending') }}</p>
                    @if(!empty($member['end_date']))
                    <p class="text-red-200 text-xs mt-1">{{ __('ui.dash_valid_until') }} {{ \Carbon\Carbon::parse($member['end_date'])->format('d M Y') }}</p>
                    @endif
                    <div class="mt-4 flex justify-center gap-2">
                        <a href="{{ url('/profile/me') }}" class="bg-white/20 hover:bg-white/30 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                            {{ __('ui.view_profile') }}
                        </a>
                        <a href="{{ url('/profile/edit') }}" class="bg-white text-primary text-xs font-semibold px-3 py-1.5 rounded-lg hover:bg-red-50 transition">
                            {{ __('ui.edit_profile') }}
                        </a>
                    </div>
                </div>

                {{-- Package / Quota Card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <div class="flex items-center justify-between mb-1">
                        <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide">{{ __('ui.dash_package_info') }}</h3>
                    </div>
                    <div class="mb-4 flex items-center justify-between">
                        <span class="text-xs text-gray-500">{{ __('ui.dash_current_plan') }}</span>
                        <span class="text-xs font-bold text-primary bg-red-50 px-2 py-0.5 rounded-full">{{ $membershipType }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-primary/5 rounded-xl p-3 text-center">
                            <div class="text-2xl font-bold text-primary">{{ $member['profiles_view_remaining'] ?? '—' }}</div>
                            <div class="text-gray-500 text-xs mt-1 leading-tight">{{ __('ui.dash_profile_views_left') }}</div>
                            @if(!is_null($member['profiles_view_allowed'] ?? null))
                            <div class="text-gray-400 text-xs">{{ __('ui.of') }} {{ $member['profiles_view_allowed'] }}</div>
                            @endif
                        </div>
                        <div class="bg-primary/5 rounded-xl p-3 text-center">
                            <div class="text-2xl font-bold text-primary">{{ $member['sent_interest_remaining'] ?? '—' }}</div>
                            <div class="text-gray-500 text-xs mt-1 leading-tight">{{ __('ui.dash_interests_left') }}</div>
                            @if(!is_null($member['sent_interest_allowed'] ?? null))
                            <div class="text-gray-400 text-xs">{{ __('ui.of') }} {{ $member['sent_interest_allowed'] }}</div>
                            @endif
                        </div>
                        <div class="bg-primary/5 rounded-xl p-3 text-center">
                            <div class="text-2xl font-bold text-primary">{{ $member['messages_sent_remaining'] ?? '—' }}</div>
                            <div class="text-gray-500 text-xs mt-1 leading-tight">{{ __('ui.dash_messages_left') }}</div>
                            @if(!is_null($member['messages_sent_allowed'] ?? null))
                            <div class="text-gray-400 text-xs">{{ __('ui.of') }} {{ $member['messages_sent_allowed'] }}</div>
                            @endif
                        </div>
                        <div class="bg-primary/5 rounded-xl p-3 text-center">
                            <div class="text-2xl font-bold text-primary">{{ $notifCount }}</div>
                            <div class="text-gray-500 text-xs mt-1 leading-tight">{{ __('ui.notifications') }}</div>
                        </div>
                    </div>
                    <a href="{{ url('/plans') }}" class="mt-4 block w-full bg-primary text-white text-xs font-semibold text-center py-2 rounded-lg hover:bg-red-900 transition">
                        {{ __('ui.dash_upgrade_plan') }}
                    </a>
                </div>

            </div>

            {{-- RIGHT CONTENT --}}
            <div class="flex-1 space-y-6">

                {{-- Activity Stats --}}
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <a href="{{ url('/interests?tab=sent') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 text-center hover:shadow-md transition group block">
                        <div class="w-10 h-10 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-2 group-hover:bg-primary transition">
                            <i class="fas fa-paper-plane text-primary group-hover:text-white transition text-sm"></i>
                        </div>
                        <div class="text-2xl font-bold text-primary">{{ $member['interests_sent'] }}</div>
                        <div class="text-gray-500 text-sm mt-1">{{ __('ui.dash_interests_sent') }}</div>
                        <div class="text-xs text-primary mt-1 opacity-0 group-hover:opacity-100 transition">{{ __('ui.dash_view_all') }} →</div>
                    </a>
                    <a href="{{ url('/interests?tab=received') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 text-center hover:shadow-md transition group block">
                        <div class="w-10 h-10 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-2 group-hover:bg-primary transition">
                            <i class="fas fa-heart text-primary group-hover:text-white transition text-sm"></i>
                        </div>
                        <div class="text-2xl font-bold text-primary">{{ $member['interests_received'] }}</div>
                        <div class="text-gray-500 text-sm mt-1">{{ __('ui.dash_interests_received') }}</div>
                        <div class="text-xs text-primary mt-1 opacity-0 group-hover:opacity-100 transition">{{ __('ui.dash_view_all') }} →</div>
                    </a>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 text-center">
                        <div class="w-10 h-10 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-eye text-primary text-sm"></i>
                        </div>
                        <div class="text-2xl font-bold text-primary">{{ $member['profiles_viewed'] }}</div>
                        <div class="text-gray-500 text-sm mt-1">{{ __('ui.dash_profiles_viewed') }}</div>
                    </div>
                        <a href="{{ url('/shortlisted') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 text-center hover:shadow-md transition group block">
                        <div class="w-10 h-10 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-2 group-hover:bg-primary transition">
                            <i class="fas fa-bookmark text-primary group-hover:text-white transition text-sm"></i>
                        </div>
                        <div class="text-2xl font-bold text-primary">{{ $member['shortlisted_count'] ?? 0 }}</div>
                        <div class="text-gray-500 text-sm mt-1">{{ __('ui.shortlist') }}</div>
                        <div class="text-xs text-primary mt-1 opacity-0 group-hover:opacity-100 transition">{{ __('ui.dash_view_all') }} →</div>
                    </a>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 text-center">
                        <div class="w-10 h-10 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-user-plus text-primary text-sm"></i>
                        </div>
                        <div class="text-2xl font-bold text-primary">{{ $member['following_count'] ?? 0 }}</div>
                        <div class="text-gray-500 text-sm mt-1">{{ __('ui.dash_following') }}</div>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h3 class="text-sm font-bold text-gray-700 mb-4 uppercase tracking-wide">{{ __('ui.quick_links') }}</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ url('/members') }}" class="flex items-center space-x-3 bg-gray-50 rounded-xl p-4 hover:shadow-md transition group">
                            <div class="w-10 h-10 bg-red-50 rounded-full flex items-center justify-center flex-shrink-0 group-hover:bg-primary transition">
                                <i class="fas fa-users text-primary group-hover:text-white transition text-sm"></i>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-700">{{ __('ui.browse_members') }}</div>
                                <div class="text-xs text-gray-400">{{ __('ui.dash_find_your_match') }}</div>
                            </div>
                        </a>
                        <a href="{{ url('/plans') }}" class="flex items-center space-x-3 bg-gray-50 rounded-xl p-4 hover:shadow-md transition group">
                            <div class="w-10 h-10 bg-red-50 rounded-full flex items-center justify-center flex-shrink-0 group-hover:bg-primary transition">
                                <i class="fas fa-crown text-primary group-hover:text-white transition text-sm"></i>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-700">{{ __('ui.dash_upgrade_plan') }}</div>
                                <div class="text-xs text-gray-400">{{ __('ui.dash_get_more_features') }}</div>
                            </div>
                        </a>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection

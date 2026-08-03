@extends('layouts.app')

@section('title', ($member['basic']['name'] ?? __('ui.ms_member_profile')) . ' | Thirumanam')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">

    {{-- BACK BUTTON --}}
    <button onclick="history.back()" class="mb-4 flex items-center gap-2 text-sm text-primary hover:text-red-800 font-medium">
        <i class="fas fa-arrow-left"></i>
        {{ __('ui.back') }}
    </button>

    {{-- PROFILE HEADER --}}
    <div class="bg-white rounded-2xl shadow-md overflow-hidden mb-4">
        <div style="background: linear-gradient(to right, #c94040, #e8607a); height: 5rem; position: relative;">
            <div class="absolute -bottom-10 left-6">
                <div class="w-20 h-20 rounded-full border-4 border-white bg-gray-200 overflow-hidden shadow flex-shrink-0">
                    @if(!empty($member['basic']['profile_photo']))
                        <img src="{{ $member['basic']['profile_photo'] }}" alt="Profile Photo" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-[#8B1A1A]/10">
                            <i class="fas fa-user text-3xl text-[#8B1A1A]/40"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="pt-12 px-6 pb-5 flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="flex-1">
                <h1 class="text-xl font-bold text-gray-900">{{ $member['basic']['name'] ?? __('ui.ms_unknown') }}</h1>
                <p class="text-gray-500 text-sm mt-0.5">
                    {{ $member['member_no'] ?? '' }}
                    @if(!empty($member['basic']['age'])) &bull; {{ $member['basic']['age'] }} {{ __('ui.yrs') }} @endif
                    @if(!empty($member['basic']['gender'])) &bull; {{ ucfirst($member['basic']['gender']) }} @endif
                </p>
            </div>

            {{-- ACTION BUTTONS --}}
            @if($member['is_own'] ?? false)
                <div class="flex gap-2">
                    <a href="{{ url('/profile/edit') }}"
                        class="px-4 py-2 bg-[#8B1A1A] text-white rounded-lg text-sm hover:bg-[#6e1515] transition">
                        <i class="fas fa-user-edit mr-1"></i> {{ __('ui.ms_edit_profile') }}
                    </a>
                    <button onclick="document.getElementById('deactivateModal').classList.remove('hidden')"
                        class="px-4 py-2 border border-red-400 text-red-500 rounded-lg text-sm hover:bg-red-50 transition">
                        <i class="fas fa-power-off mr-1"></i> {{ __('ui.ms_deactivate') }}
                    </button>
                </div>

                {{-- Deactivate Modal --}}
                <div id="deactivateModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
                    <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full p-6">
                        <div class="text-center mb-4">
                            <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-power-off text-red-500 text-xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">{{ __('ui.ms_deactivate_title') }}</h3>
                            <p class="text-gray-500 text-sm mt-2">{{ __('ui.ms_deactivate_body') }}</p>
                        </div>
                        <div class="flex gap-3 mt-5">
                            <button onclick="document.getElementById('deactivateModal').classList.add('hidden')"
                                class="flex-1 px-4 py-2 border border-gray-300 text-gray-600 rounded-lg text-sm hover:bg-gray-50 transition">
                                {{ __('ui.ms_cancel') }}
                            </button>
                            <button onclick="confirmDeactivate()" id="deactivateBtn"
                                class="flex-1 px-4 py-2 bg-red-500 text-white rounded-lg text-sm hover:bg-red-600 transition">
                                {{ __('ui.ms_yes_deactivate') }}
                            </button>
                        </div>
                    </div>
                </div>

            @elseif(!($member['restricted'] ?? true))
                {{-- Only paid plan viewers get interaction buttons --}}
                @php
                    $interactions    = $member['interactions'] ?? [];
                    $hasSentInterest = $interactions['has_sent_interest'] ?? false;
                    $isFollowing     = $interactions['is_following'] ?? false;
                    $hasShortlisted  = $interactions['has_shortlisted'] ?? false;
                    $hasBlocked      = $interactions['has_blocked'] ?? false;
                @endphp
                <div class="flex gap-2 flex-wrap">
                    <button onclick="sendInterest({{ $member['id'] }}, {{ $member['profile_id'] ?? 0 }})"
                        {{ $hasSentInterest ? 'disabled' : '' }}
                        class="px-4 py-2 rounded-lg text-sm transition {{ $hasSentInterest ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-[#F24570] text-white hover:bg-[#d63560]' }}">
                        <i class="fas fa-heart mr-1"></i> {{ $hasSentInterest ? __('ui.ms_interest_sent') : __('ui.ms_interest') }}
                    </button>
                    <button id="shortlistBtn"
                        onclick="toggleShortlist(this, {{ $member['id'] }}, {{ $member['profile_id'] ?? 0 }})"
                        data-active="{{ $hasShortlisted ? 'true' : 'false' }}"
                        class="px-4 py-2 rounded-lg text-sm transition {{ $hasShortlisted ? 'bg-[#8B1A1A] text-white' : 'border border-[#8B1A1A] text-[#8B1A1A] hover:bg-[#8B1A1A]/10' }}">
                        <i class="fas fa-bookmark mr-1"></i> <span>{{ $hasShortlisted ? __('ui.ms_shortlisted') : __('ui.ms_shortlist') }}</span>
                    </button>
                    <button id="followBtn"
                        onclick="toggleFollow(this, {{ $member['id'] }}, {{ $member['profile_id'] ?? 0 }})"
                        data-active="{{ $isFollowing ? 'true' : 'false' }}"
                        class="px-4 py-2 rounded-lg text-sm transition {{ $isFollowing ? 'bg-blue-500 text-white' : 'border border-blue-400 text-blue-500 hover:bg-blue-50' }}">
                        <i class="fas fa-user-plus mr-1"></i> <span>{{ $isFollowing ? __('ui.ms_following') : __('ui.ms_follow') }}</span>
                    </button>
                    <button onclick="window.location.href='{{ url('/messages') }}?to={{ $member['profile_id'] ?? 0 }}'" class="px-4 py-2 rounded-lg text-sm transition bg-green-500 text-white hover:bg-green-600">
                        <i class="fas fa-comment-dots mr-1"></i> {{ __('ui.messages') }}
                    </button>
                    <button onclick="blockMember({{ $member['id'] }}, {{ $member['profile_id'] ?? 0 }})"
                        class="px-4 py-2 border border-gray-300 text-gray-500 rounded-lg text-sm hover:bg-gray-100 transition">
                        <i class="fas fa-ban mr-1"></i> {{ $hasBlocked ? __('ui.ms_unblock') : __('ui.ms_block') }}
                    </button>
                    <button onclick="document.getElementById('reportModal').classList.remove('hidden')"
                        class="px-4 py-2 border border-orange-300 text-orange-500 rounded-lg text-sm hover:bg-orange-50 transition">
                        <i class="fas fa-flag mr-1"></i> {{ __('ui.ms_report') }}
                    </button>
                </div>
            @endif

            {{-- Report Modal --}}
            @if(!($member['is_own'] ?? false))
            <div id="reportModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
                <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-3"><i class="fas fa-flag text-orange-400 mr-2"></i>{{ __('ui.ms_report_title') }}</h3>
                    <p class="text-gray-500 text-sm mb-4">{{ __('ui.ms_report_body') }}</p>
                    <textarea id="reportReason" rows="3" placeholder="{{ __('ui.ms_report_placeholder') }}"
                        class="w-full border border-gray-200 rounded-lg p-3 text-sm text-gray-700 focus:outline-none focus:border-orange-400 resize-none"></textarea>
                    <div class="flex gap-3 mt-4">
                        <button onclick="document.getElementById('reportModal').classList.add('hidden')"
                            class="flex-1 px-4 py-2 border border-gray-300 text-gray-600 rounded-lg text-sm hover:bg-gray-50 transition">
                            {{ __('ui.ms_cancel') }}
                        </button>
                        <button onclick="submitReport({{ $member['id'] }}, {{ $member['profile_id'] ?? 0 }})"
                            id="reportBtn"
                            class="flex-1 px-4 py-2 bg-orange-500 text-white rounded-lg text-sm hover:bg-orange-600 transition">
                            {{ __('ui.ms_submit_report') }}
                        </button>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- UPGRADE BANNER — only for default plan, non-own profiles --}}
    @if(($member['restricted'] ?? false) && !($member['is_own'] ?? false))
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-4 flex flex-col sm:flex-row items-center justify-between gap-3">
        <div>
            <p class="font-semibold text-yellow-800"><i class="fas fa-lock mr-2"></i>{{ __('ui.ms_restricted_banner_title') }}</p>
            <p class="text-yellow-700 text-sm mt-1">{{ __('ui.ms_restricted_banner_body') }}</p>
        </div>
        <a href="/plans" class="px-5 py-2 bg-[#8B1A1A] text-white rounded-lg text-sm font-semibold hover:bg-[#6e1515] transition whitespace-nowrap">{{ __('ui.ms_upgrade_now') }}</a>
    </div>
    @endif

    {{-- FULL PROFILE — all members see tabs --}}
    <div x-data="{ tab: 'basic' }">

        {{-- TABS --}}
        <div class="flex gap-2 overflow-x-auto mb-4 pb-1">
            @foreach([
                'basic'    => __('ui.ms_tab_basic'),
                'horoscope'=> __('ui.ms_tab_horoscope'),
                'physical' => __('ui.ms_tab_physical'),
                'career'   => __('ui.ms_tab_career'),
                'family'   => __('ui.ms_tab_family'),
                'contact'  => __('ui.ms_tab_contact'),
                'partner'  => __('ui.ms_tab_partner'),
            ] as $key => $label)
            <button @click="tab = '{{ $key }}'"
                :class="tab === '{{ $key }}' ? 'bg-[#8B1A1A] text-white' : 'bg-white text-gray-600 border border-gray-200'"
                class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition flex items-center gap-1">
                @if(($member['restricted'] ?? false) && !($member['is_own'] ?? false) && in_array($key, ['family', 'contact']))
                    <i class="fas fa-lock text-xs opacity-60"></i>
                @endif
                {{ $label }}
            </button>
            @endforeach
        </div>

        {{-- BASIC TAB --}}
        <div x-show="tab === 'basic'">
            @if(!empty($member['basic']['introduction']))
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4">
                <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 rounded-t-2xl">
                    <h2 class="text-sm font-semibold text-[#8B1A1A] uppercase tracking-wide">{{ __('ui.ms_introduction') }}</h2>
                </div>
                <div class="p-5">
                    <p class="text-gray-700 text-sm leading-relaxed">{{ $member['basic']['introduction'] }}</p>
                </div>
            </div>
            @endif
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4">
                <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 rounded-t-2xl">
                    <h2 class="text-sm font-semibold text-[#8B1A1A] uppercase tracking-wide">{{ __('ui.ms_basic_information') }}</h2>
                </div>
                <div class="px-5 py-2">
                    @foreach([
                        __('ui.ms_label_age')           => $member['basic']['age'] ?? null,
                        __('ui.ms_label_dob')            => $member['basic']['dob'] ?? null,
                        __('ui.ms_label_gender')         => ucfirst($member['basic']['gender'] ?? ''),
                        __('ui.ms_label_marital_status') => ucwords(str_replace('_', ' ', $member['basic']['marital_status'] ?? '')),
                        __('ui.ms_label_religion')       => $member['basic']['religion'] ?? null,
                        __('ui.ms_label_caste')          => $member['basic']['caste'] ?? null,
                        __('ui.ms_label_subcaste')       => $member['basic']['subcaste'] ?? null,
                        __('ui.ms_label_mother_tongue')  => $member['basic']['mother_tongue'] ?? null,
                        __('ui.ms_label_city')           => $member['basic']['city'] ?? null,
                        __('ui.ms_label_state')          => $member['basic']['state'] ?? null,
                        __('ui.ms_label_country')        => $member['basic']['country'] ?? null,
                    ] as $label => $value)
                    <div class="flex py-2 border-b border-gray-50 last:border-0">
                        <span class="w-2/5 text-xs text-gray-500 font-medium uppercase tracking-wide pt-0.5">{{ $label }}</span>
                        <span class="w-3/5 text-sm text-gray-800 font-medium break-words">{{ $value ?: '—' }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- HOROSCOPE TAB --}}
        <div x-show="tab === 'horoscope'">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4">
                <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 rounded-t-2xl">
                    <h2 class="text-sm font-semibold text-[#8B1A1A] uppercase tracking-wide">{{ __('ui.ms_astronomic_information') }}</h2>
                </div>
                <div class="px-5 py-2">
                    @foreach([
                        __('ui.ms_label_dob')                => $member['horoscope']['dob'] ?? null,
                        __('ui.ms_label_birth_time')         => $member['horoscope']['birth_time'] ?? null,
                        __('ui.ms_label_birth_city')         => $member['horoscope']['birth_city'] ?? null,
                        __('ui.ms_label_birth_place')        => $member['horoscope']['birth_place'] ?? null,
                        __('ui.ms_label_star')                => tv('star', $member['horoscope']['star'] ?? null),
                        __('ui.ms_label_rasi')                => tv('rasi', $member['horoscope']['rasi'] ?? null),
                        __('ui.ms_label_nakshatra')           => $member['horoscope']['nakshatra'] ?? null,
                        __('ui.ms_label_padam')               => tv('padam', $member['horoscope']['padam'] ?? null),
                        __('ui.ms_label_lakknam')             => tv('lakknam', $member['horoscope']['lakknam'] ?? null),
                        __('ui.ms_label_paksha')              => tv('paksha', $member['horoscope']['paksha'] ?? null),
                        __('ui.ms_label_tithi')               => tv('tithi', $member['horoscope']['tithi'] ?? null),
                        __('ui.ms_label_ganam')               => $member['horoscope']['ganam'] ?? null,
                        __('ui.ms_label_nadi')                => $member['horoscope']['nadi'] ?? null,
                        __('ui.ms_label_dosham')              => tv('dosham', $member['horoscope']['dosham'] ?? null),
                        __('ui.ms_label_horoscope_matching')  => $member['horoscope']['horoscope_matching'] ?? null,
                        __('ui.ms_label_directional_balance') => $member['horoscope']['directional_balance'] ?? null,
                    ] as $label => $value)
                    <div class="flex py-2 border-b border-gray-50 last:border-0">
                        <span class="w-2/5 text-xs text-gray-500 font-medium uppercase tracking-wide pt-0.5">{{ $label }}</span>
                        <span class="w-3/5 text-sm text-gray-800 font-medium break-words">{{ $value ?: '—' }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- RASI CHART --}}
            @php
                $boxes = $member['horoscope_boxes'];
                $boxes = is_array($boxes) ? $boxes : $boxes->toArray();
                $grid = ['ZODIAC' => [], 'FEATURE' => []];
                foreach($boxes as $box) {
                    if (!is_array($box)) continue;
                    $box = (array)$box;
                    $type = $box['type'] ?? 'ZODIAC';
                    $bn   = $box['box_number'] ?? 0;
                    $val  = $box['value'] ?? '';
                    if (!isset($grid[$type][$bn])) $grid[$type][$bn] = [];
                    if ($val) $grid[$type][$bn][] = $val;
                }
                $getBox = function($grid, $type, $bn) {
                    $items = $grid[$type][$bn] ?? [];
                    if (empty($items)) return '&nbsp;';
                    return implode(' | ', array_filter($items)) ?: '&nbsp;';
                };
            @endphp
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4">
                <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 rounded-t-2xl">
                    <h2 class="text-sm font-semibold text-[#8B1A1A] uppercase tracking-wide">{{ __('ui.ms_rasi_chart') }}</h2>
                </div>
                <div class="p-3 overflow-x-auto">
                    <table class="w-full border-collapse text-xs" style="min-width:280px">
                        <tbody>
                            <tr>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em;width:25%">{!! $getBox($grid,'ZODIAC',1) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em;width:25%">{!! $getBox($grid,'ZODIAC',2) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em;width:25%">{!! $getBox($grid,'ZODIAC',3) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em;width:25%">{!! $getBox($grid,'ZODIAC',4) !!}</td>
                            </tr>
                            <tr>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid,'ZODIAC',5) !!}</td>
                                <td class="border-2 border-green-300 p-2 text-center bg-yellow-50 font-semibold text-gray-600 align-middle" colspan="2" rowspan="2">{{ __('ui.ms_zodiac') }}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid,'ZODIAC',6) !!}</td>
                            </tr>
                            <tr>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid,'ZODIAC',7) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid,'ZODIAC',8) !!}</td>
                            </tr>
                            <tr>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid,'ZODIAC',9) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid,'ZODIAC',10) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid,'ZODIAC',11) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid,'ZODIAC',12) !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4">
                <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 rounded-t-2xl">
                    <h2 class="text-sm font-semibold text-[#8B1A1A] uppercase tracking-wide">{{ __('ui.ms_navamsa_chart') }}</h2>
                </div>
                <div class="p-3 overflow-x-auto">
                    <table class="w-full border-collapse text-xs" style="min-width:280px">
                        <tbody>
                            <tr>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em;width:25%">{!! $getBox($grid,'FEATURE',1) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em;width:25%">{!! $getBox($grid,'FEATURE',2) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em;width:25%">{!! $getBox($grid,'FEATURE',3) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em;width:25%">{!! $getBox($grid,'FEATURE',4) !!}</td>
                            </tr>
                            <tr>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid,'FEATURE',5) !!}</td>
                                <td class="border-2 border-green-300 p-2 text-center bg-yellow-50 font-semibold text-gray-600 align-middle" colspan="2" rowspan="2">{{ __('ui.ms_feature') }}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid,'FEATURE',6) !!}</td>
                            </tr>
                            <tr>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid,'FEATURE',7) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" colspan="2" style="height:5.5em">{!! $getBox($grid,'FEATURE',8) !!}</td>
                            </tr>
                            <tr>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid,'FEATURE',9) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid,'FEATURE',10) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid,'FEATURE',11) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid,'FEATURE',12) !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- PHYSICAL TAB --}}
        <div x-show="tab === 'physical'">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4">
                <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 rounded-t-2xl">
                    <h2 class="text-sm font-semibold text-[#8B1A1A] uppercase tracking-wide">{{ __('ui.ms_physical_attributes') }}</h2>
                </div>
                <div class="px-5 py-2">
                    @foreach([
                        __('ui.ms_label_height')          => !empty($member['physical']['height']) ? $member['physical']['height'] . ' cm' : null,
                        __('ui.ms_label_weight')          => !empty($member['physical']['weight']) ? $member['physical']['weight'] . ' kg' : null,
                        __('ui.ms_label_complexion')      => ucfirst($member['physical']['complexion'] ?? ''),
                        __('ui.ms_label_body_type')       => ucfirst(str_replace('_', ' ', $member['physical']['body_type'] ?? '')),
                        __('ui.ms_label_blood_group')     => $member['physical']['blood_group'] ?? null,
                        __('ui.ms_label_physical_status') => ucfirst($member['physical']['physical_status'] ?? ''),
                        __('ui.ms_label_eye_color')       => $member['physical']['eye_color'] ?? null,
                        __('ui.ms_label_hair_color')      => $member['physical']['hair_color'] ?? null,
                    ] as $label => $value)
                    <div class="flex py-2 border-b border-gray-50 last:border-0">
                        <span class="w-2/5 text-xs text-gray-500 font-medium uppercase tracking-wide pt-0.5">{{ $label }}</span>
                        <span class="w-3/5 text-sm text-gray-800 font-medium break-words">{{ $value ?: '—' }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- CAREER TAB --}}
        <div x-show="tab === 'career'">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4">
                <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 rounded-t-2xl">
                    <h2 class="text-sm font-semibold text-[#8B1A1A] uppercase tracking-wide">{{ __('ui.ms_education_career') }}</h2>
                </div>
                <div class="px-5 py-2">
                    @foreach([
                        __('ui.ms_label_education')      => ucwords(str_replace(['_', '/'], [' ', ' / '], $member['career']['education'] ?? '')),
                        __('ui.ms_label_study_details')  => $member['career']['study_details'] ?? null,
                        __('ui.ms_label_occupation')     => ucwords(str_replace('_', ' ', $member['career']['occupation'] ?? '')),
                        __('ui.ms_label_work_location')  => $member['career']['work_location'] ?? null,
                        __('ui.ms_label_income')         => ucfirst($member['career']['income'] ?? ''),
                        __('ui.ms_label_income_amount')  => !empty($member['career']['income_amount']) ? '₹' . number_format($member['career']['income_amount']) : null,
                        __('ui.ms_label_earnings_type')  => ucfirst($member['career']['earnings'] ?? ''),
                        __('ui.ms_label_career_profile') => $member['career']['career_profile'] ?? null,
                    ] as $label => $value)
                    <div class="flex py-2 border-b border-gray-50 last:border-0">
                        <span class="w-2/5 text-xs text-gray-500 font-medium uppercase tracking-wide pt-0.5">{{ $label }}</span>
                        <span class="w-3/5 text-sm text-gray-800 font-medium break-words">{{ $value ?: '—' }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- FAMILY TAB --}}
        <div x-show="tab === 'family'">
            @if(($member['restricted'] ?? false) && !($member['is_own'] ?? false))
                {{-- LOCKED --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4">
                    <div class="p-10 flex flex-col items-center text-center gap-3">
                        <div class="w-14 h-14 rounded-full bg-yellow-100 flex items-center justify-center">
                            <i class="fas fa-lock text-yellow-600 text-xl"></i>
                        </div>
                        <h3 class="text-base font-semibold text-gray-800">{{ __('ui.ms_family_locked_title') }}</h3>
                        <p class="text-gray-500 text-sm max-w-xs">{{ __('ui.ms_family_locked_body') }}</p>
                        <a href="/plans" class="mt-2 px-6 py-2 bg-[#8B1A1A] text-white rounded-lg text-sm font-semibold hover:bg-[#6e1515] transition">
                            <i class="fas fa-arrow-up mr-1"></i> {{ __('ui.ms_upgrade_plan') }}
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4">
                    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 rounded-t-2xl">
                        <h2 class="text-sm font-semibold text-[#8B1A1A] uppercase tracking-wide">{{ __('ui.ms_family_information') }}</h2>
                    </div>
                    <div class="px-5 py-2">
                        @php $fam = is_array($member['family'] ?? []) ? ($member['family'] ?? []) : (array)$member['family']; @endphp
                        @foreach([
                            __('ui.ms_label_surname')           => $fam['surname'] ?? null,
                            __('ui.ms_label_father_name')       => $fam['father_name'] ?? null,
                            __('ui.ms_label_father_occupation') => $fam['father_occupation'] ?? null,
                            __('ui.ms_label_father_vangusam')   => $fam['father_vangusam'] ?? null,
                            __('ui.ms_label_mother_name')       => $fam['mother_name'] ?? null,
                            __('ui.ms_label_mother_occupation') => $fam['mother_occupation'] ?? null,
                            __('ui.ms_label_mother_vangusam')   => $fam['mother_vangusam'] ?? null,
                            __('ui.ms_label_brothers_count')    => isset($fam['brothers_count']) ? $fam['brothers_count'] : null,
                            __('ui.ms_label_brothers_married')  => isset($fam['brothers_married']) ? $fam['brothers_married'] : null,
                            __('ui.ms_label_sisters_count')     => isset($fam['sisters_count']) ? $fam['sisters_count'] : null,
                            __('ui.ms_label_sisters_married')   => isset($fam['sisters_married']) ? $fam['sisters_married'] : null,
                            __('ui.ms_label_family_type')       => ucfirst($fam['family_type'] ?? ''),
                            __('ui.ms_label_family_status')     => ucfirst($fam['family_status'] ?? ''),
                            __('ui.ms_label_family_values')     => ucfirst($fam['family_values'] ?? ''),
                            __('ui.ms_label_soveran_details')   => $fam['soveran_details'] ?? null,
                            __('ui.ms_label_property')          => $fam['property_description'] ?? null,
                            __('ui.ms_label_about_family')      => $fam['about_family'] ?? null,
                        ] as $label => $value)
                        <div class="flex py-2 border-b border-gray-50 last:border-0">
                            <span class="w-2/5 text-xs text-gray-500 font-medium uppercase tracking-wide pt-0.5">{{ $label }}</span>
                            <span class="w-3/5 text-sm text-gray-800 font-medium break-words">{{ $value ?: '—' }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- CONTACT TAB --}}
        <div x-show="tab === 'contact'">
            @if(($member['restricted'] ?? false) && !($member['is_own'] ?? false))
                {{-- LOCKED --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4">
                    <div class="p-10 flex flex-col items-center text-center gap-3">
                        <div class="w-14 h-14 rounded-full bg-yellow-100 flex items-center justify-center">
                            <i class="fas fa-lock text-yellow-600 text-xl"></i>
                        </div>
                        <h3 class="text-base font-semibold text-gray-800">{{ __('ui.ms_contact_locked_title') }}</h3>
                        <p class="text-gray-500 text-sm max-w-xs">{{ __('ui.ms_contact_locked_body') }}</p>
                        <a href="/plans" class="mt-2 px-6 py-2 bg-[#8B1A1A] text-white rounded-lg text-sm font-semibold hover:bg-[#6e1515] transition">
                            <i class="fas fa-arrow-up mr-1"></i> {{ __('ui.ms_upgrade_plan') }}
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4">
                    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 rounded-t-2xl">
                        <h2 class="text-sm font-semibold text-[#8B1A1A] uppercase tracking-wide">{{ __('ui.ms_contact_address') }}</h2>
                    </div>
                    <div class="px-5 py-2">
                        @foreach([
                            __('ui.ms_label_mobile')            => $member['contact']['mobile'] ?? null,
                            __('ui.ms_label_alternate_number')  => $member['contact']['alternate_number'] ?? null,
                            __('ui.ms_label_landline')          => $member['contact']['landline'] ?? null,
                            __('ui.ms_label_current_city')      => $member['contact']['current_city'] ?? null,
                            __('ui.ms_label_native_place')      => $member['contact']['native_place'] ?? null,
                            __('ui.ms_label_state')             => $member['contact']['state'] ?? null,
                            __('ui.ms_label_country')           => $member['contact']['country'] ?? null,
                            __('ui.ms_label_postal_code')       => $member['contact']['postal_code'] ?? null,
                            __('ui.ms_label_address')           => $member['contact']['address'] ?? null,
                        ] as $label => $value)
                        <div class="flex py-2 border-b border-gray-50 last:border-0">
                            <span class="w-2/5 text-xs text-gray-500 font-medium uppercase tracking-wide pt-0.5">{{ $label }}</span>
                            <span class="w-3/5 text-sm text-gray-800 font-medium break-words">{{ $value ?: '—' }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- PARTNER PREF TAB --}}
        <div x-show="tab === 'partner'">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4">
                <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 rounded-t-2xl">
                    <h2 class="text-sm font-semibold text-[#8B1A1A] uppercase tracking-wide">{{ __('ui.ms_partner_expectations') }}</h2>
                </div>
                <div class="px-5 py-2">
                    @php $pp = is_array($member['partner_preference'] ?? []) ? ($member['partner_preference'] ?? []) : (array)$member['partner_preference']; @endphp
                    @php
                        $ageRange = null;
                        if (!empty($pp['preferred_age_min']) || !empty($pp['preferred_age_max'])) {
                            $ageRange = ($pp['preferred_age_min'] ?? '—') . ' – ' . ($pp['preferred_age_max'] ?? '—') . ' yrs';
                        } elseif (!empty($pp['preferred_age'])) {
                            $ageRange = $pp['preferred_age'];
                        }
                        $heightRange = null;
                        if (!empty($pp['preferred_height_min']) || !empty($pp['preferred_height_max'])) {
                            $heightRange = ($pp['preferred_height_min'] ?? '—') . ' – ' . ($pp['preferred_height_max'] ?? '—') . ' cm';
                        } elseif (!empty($pp['preferred_height'])) {
                            $heightRange = $pp['preferred_height'];
                        }
                    @endphp
                    @foreach([
                        __('ui.ms_label_preferred_age')           => $ageRange,
                        __('ui.ms_label_preferred_height')        => $heightRange,
                        __('ui.ms_label_marital_status')          => ucwords(str_replace('_', ' ', $pp['marital_status'] ?? '')),
                        __('ui.ms_label_children_acceptables')    => ucfirst($pp['children_acceptables'] ?? ''),
                        __('ui.ms_label_religion')                => $pp['religion'] ?? null,
                        __('ui.ms_label_caste')                   => $pp['caste'] ?? null,
                        __('ui.ms_label_education')               => ucwords(str_replace(['_', '/'], [' ', ' / '], $pp['education'] ?? '')),
                        __('ui.ms_label_occupation')              => ucwords(str_replace('_', ' ', $pp['occupation'] ?? '')),
                        __('ui.ms_label_profession')              => ucwords(str_replace('_', ' ', $pp['profession'] ?? '')),
                        __('ui.ms_label_location')                => $pp['location'] ?? null,
                        __('ui.ms_label_family_type')             => ucfirst($pp['family_type'] ?? ''),
                        __('ui.ms_label_body_type')               => ucfirst($pp['body_type'] ?? ''),
                        __('ui.ms_label_physical_status')         => ucfirst(str_replace('_', ' ', $pp['physical_status'] ?? '')),
                        __('ui.ms_label_horoscope_required')      => isset($pp['horoscope_required']) && $pp['horoscope_required'] !== '' ? ($pp['horoscope_required'] ? __('ui.pe_opt_yes') : __('ui.pe_opt_no')) : null,
                        __('ui.ms_label_horoscope_natchathiram')  => $pp['horoscope_natchathiram'] ?? null,
                        __('ui.ms_label_horoscope_rasi')          => $pp['horoscope_rasi'] ?? null,
                        __('ui.ms_label_dosham')                  => ucfirst($pp['dosham'] ?? ''),
                        __('ui.ms_label_type_of_dosham')          => $pp['type_of_dosham'] ?? null,
                        __('ui.ms_label_drinking')                => ucfirst($pp['drinking'] ?? ''),
                        __('ui.ms_label_smoking')                 => ucfirst($pp['smoking'] ?? ''),
                        __('ui.ms_label_expectations')            => $pp['expectations'] ?? null,
                    ] as $label => $value)
                    <div class="flex py-2 border-b border-gray-50 last:border-0">
                        <span class="w-2/5 text-xs text-gray-500 font-medium uppercase tracking-wide pt-0.5">{{ $label }}</span>
                        <span class="w-3/5 text-sm text-gray-800 font-medium break-words">{{ $value ?: '—' }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

</div>

<script>
const msI18n = {
    interestSent:   @json(__('ui.ms_interest_sent')),
    interest:       @json(__('ui.ms_interest')),
    shortlisted:    @json(__('ui.ms_shortlisted')),
    shortlist:      @json(__('ui.ms_shortlist')),
    following:      @json(__('ui.ms_following')),
    follow:         @json(__('ui.ms_follow')),
    submitting:     @json(__('ui.ms_submitting')),
    submitReport:   @json(__('ui.ms_submit_report')),
    deactivating:   @json(__('ui.ms_deactivating')),
    yesDeactivate:  @json(__('ui.ms_yes_deactivate')),
    blockConfirm:   @json(__('ui.ms_block_confirm')),
    reasonRequired: @json(__('ui.ms_reason_required')),
    somethingWrong: @json(__('ui.ms_something_wrong')),
};

function sendInterest(memberId, profileId) {
    fetch(`/members/${memberId}/interest`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
        body: JSON.stringify({ profile_id: profileId })
    }).then(r => r.json()).then(d => alert(d.message)).catch(() => alert(msI18n.somethingWrong));
}

function toggleShortlist(btn, memberId, profileId) {
    fetch(`/members/${memberId}/shortlist`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
        body: JSON.stringify({ profile_id: profileId })
    }).then(r => r.json()).then(d => {
        const active = d.active;
        btn.dataset.active = active;
        btn.className = `px-4 py-2 rounded-lg text-sm transition ${active ? 'bg-[#8B1A1A] text-white' : 'border border-[#8B1A1A] text-[#8B1A1A] hover:bg-[#8B1A1A]/10'}`;
        btn.querySelector('span').textContent = active ? msI18n.shortlisted : msI18n.shortlist;
    }).catch(() => alert(msI18n.somethingWrong));
}

function toggleFollow(btn, memberId, profileId) {
    fetch(`/members/${memberId}/follow`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
        body: JSON.stringify({ profile_id: profileId })
    }).then(r => r.json()).then(d => {
        const active = d.active;
        btn.dataset.active = active;
        btn.className = `px-4 py-2 rounded-lg text-sm transition ${active ? 'bg-blue-500 text-white' : 'border border-blue-400 text-blue-500 hover:bg-blue-50'}`;
        btn.querySelector('span').textContent = active ? msI18n.following : msI18n.follow;
    }).catch(() => alert(msI18n.somethingWrong));
}

function blockMember(memberId, profileId) {
    if (!confirm(msI18n.blockConfirm)) return;
    fetch(`/members/${memberId}/block`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
        body: JSON.stringify({ profile_id: profileId })
    }).then(r => r.json()).then(d => alert(d.message)).catch(() => alert(msI18n.somethingWrong));
}

function submitReport(memberId, profileId) {
    const reason = document.getElementById('reportReason').value.trim();
    if (!reason) { alert(msI18n.reasonRequired); return; }
    const btn = document.getElementById('reportBtn');
    btn.disabled = true;
    btn.textContent = msI18n.submitting;
    fetch(`/members/${memberId}/report`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
        body: JSON.stringify({ profile_id: profileId, reason })
    }).then(r => r.json()).then(d => {
        alert(d.message);
        document.getElementById('reportModal').classList.add('hidden');
        btn.disabled = false;
        btn.textContent = msI18n.submitReport;
    }).catch(() => {
        alert(msI18n.somethingWrong);
        btn.disabled = false;
        btn.textContent = msI18n.submitReport;
    });
}

function confirmDeactivate() {
    const btn = document.getElementById('deactivateBtn');
    btn.disabled = true;
    btn.textContent = msI18n.deactivating;
    fetch('/profile/deactivate', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
    }).then(r => r.json()).then(d => {
        if (d.success) {
            window.location.href = '/login?message=deactivated';
        } else {
            alert(d.message || msI18n.somethingWrong);
            btn.disabled = false;
            btn.textContent = msI18n.yesDeactivate;
        }
    }).catch(() => {
        alert(msI18n.somethingWrong);
        btn.disabled = false;
        btn.textContent = msI18n.yesDeactivate;
    });
}
</script>
@endsection

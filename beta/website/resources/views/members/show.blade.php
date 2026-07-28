@extends('layouts.app')

@section('title', ($member['basic']['name'] ?? 'Member Profile') . ' | Thirumanam')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">

    {{-- PROFILE HEADER --}}
    <div class="bg-white rounded-2xl shadow-md overflow-hidden mb-4">
        {{-- Red banner — photo only --}}
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
        {{-- Name + actions in white area --}}
        <div class="pt-12 px-6 pb-5 flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="flex-1">
                <h1 class="text-xl font-bold text-gray-900">{{ $member['basic']['name'] ?? 'Unknown' }}</h1>
                <p class="text-gray-500 text-sm mt-0.5">
                    {{ $member['member_no'] ?? '' }}
                    @if(!empty($member['basic']['age'])) &bull; {{ $member['basic']['age'] }} yrs @endif
                    @if(!empty($member['basic']['gender'])) &bull; {{ ucfirst($member['basic']['gender']) }} @endif
                </p>
            </div>
            {{-- ACTION BUTTONS --}}
            @if($member['is_own'] ?? false)
            <div class="flex gap-2">
                <a href="{{ url('/profile/edit') }}"
                    class="px-4 py-2 bg-[#8B1A1A] text-white rounded-lg text-sm hover:bg-[#6e1515] transition">
                    <i class="fas fa-user-edit mr-1"></i> Edit Profile
                </a>
            </div>
            @elseif(!($member['restricted'] ?? true))
            <div class="flex gap-2 flex-wrap">
                <button onclick="sendInterest({{ $member['id'] }}, {{ $member['profile_id'] ?? 0 }})"
                    class="px-4 py-2 bg-[#F24570] text-white rounded-lg text-sm hover:bg-[#d63560] transition">
                    <i class="fas fa-heart mr-1"></i> Interest
                </button>
                <button onclick="shortlistMember({{ $member['id'] }}, {{ $member['profile_id'] ?? 0 }})"
                    class="px-4 py-2 border border-[#8B1A1A] text-[#8B1A1A] rounded-lg text-sm hover:bg-[#8B1A1A]/10 transition">
                    <i class="fas fa-bookmark mr-1"></i> Shortlist
                </button>
                <button onclick="blockMember({{ $member['id'] }}, {{ $member['profile_id'] ?? 0 }})"
                    class="px-4 py-2 border border-gray-300 text-gray-500 rounded-lg text-sm hover:bg-gray-100 transition">
                    <i class="fas fa-ban mr-1"></i> Block
                </button>
            </div>
            @endif
        </div>
    </div>

    {{-- UPGRADE BANNER --}}
    @if($member['restricted'] ?? true)
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-4 flex flex-col sm:flex-row items-center justify-between gap-3">
        <div>
            <p class="font-semibold text-yellow-800"><i class="fas fa-lock mr-2"></i>Full profile is restricted</p>
            <p class="text-yellow-700 text-sm mt-1">Upgrade your plan to view complete profile details.</p>
        </div>
        <a href="/plans" class="px-5 py-2 bg-[#8B1A1A] text-white rounded-lg text-sm font-semibold hover:bg-[#6e1515] transition whitespace-nowrap">Upgrade Now</a>
    </div>

    {{-- BASIC INFO (restricted) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4">
        <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 rounded-t-2xl">
            <h2 class="text-sm font-semibold text-[#8B1A1A] uppercase tracking-wide">Basic Information</h2>
        </div>
        <div class="p-5 grid grid-cols-2 sm:grid-cols-3 gap-4">
            @foreach([
                'Age'            => $member['basic']['age'] ?? null,
                'Gender'         => ucfirst($member['basic']['gender'] ?? ''),
                'Marital Status' => ucwords(str_replace('_', ' ', $member['basic']['marital_status'] ?? '')),
                'Education'      => ucwords(str_replace(['_', '/'], [' ', ' / '], $member['basic']['education'] ?? '')),
                'Occupation'     => ucwords(str_replace('_', ' ', $member['basic']['occupation'] ?? '')),
                'City'           => $member['basic']['city'] ?? null,
            ] as $label => $value)
            <div class="min-w-0">
                <p class="text-xs text-gray-400 uppercase tracking-wide">{{ $label }}</p>
                <p class="text-gray-800 font-medium mt-0.5 text-sm break-words">{{ $value ?: '—' }}</p>
            </div>
            @endforeach
        </div>
    </div>

    @else
    {{-- FULL PROFILE --}}
    <div x-data="{ tab: 'basic' }">

        {{-- TABS --}}
        <div class="flex gap-2 overflow-x-auto mb-4 pb-1">
            @foreach(['basic' => 'Basic', 'horoscope' => 'Horoscope', 'physical' => 'Physical', 'career' => 'Career', 'contact' => 'Contact', 'family' => 'Family', 'partner' => 'Partner Pref'] as $key => $label)
            <button @click="tab = '{{ $key }}'"
                :class="tab === '{{ $key }}' ? 'bg-[#8B1A1A] text-white' : 'bg-white text-gray-600 border border-gray-200'"
                class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition">
                {{ $label }}
            </button>
            @endforeach
        </div>

        {{-- BASIC TAB --}}
        <div x-show="tab === 'basic'">
            @if(!empty($member['basic']['introduction']))
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4">
                <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 rounded-t-2xl">
                    <h2 class="text-sm font-semibold text-[#8B1A1A] uppercase tracking-wide">Introduction</h2>
                </div>
                <div class="p-5">
                    <p class="text-gray-700 text-sm leading-relaxed">{{ $member['basic']['introduction'] }}</p>
                </div>
            </div>
            @endif
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4">
                <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 rounded-t-2xl">
                    <h2 class="text-sm font-semibold text-[#8B1A1A] uppercase tracking-wide">Basic Information</h2>
                </div>
                <div class="px-5 py-2">
                    @foreach([
                        'Age'            => $member['basic']['age'] ?? null,
                        'Date of Birth'  => $member['basic']['dob'] ?? null,
                        'Gender'         => ucfirst($member['basic']['gender'] ?? ''),
                        'Marital Status' => ucwords(str_replace('_', ' ', $member['basic']['marital_status'] ?? '')),
                        'Religion'       => $member['basic']['religion'] ?? null,
                        'Caste'          => $member['basic']['caste'] ?? null,
                        'Sub Caste'      => $member['basic']['subcaste'] ?? null,
                        'Mother Tongue'  => $member['basic']['mother_tongue'] ?? null,
                        'City'           => $member['basic']['city'] ?? null,
                        'State'          => $member['basic']['state'] ?? null,
                        'Country'        => $member['basic']['country'] ?? null,
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
                    <h2 class="text-sm font-semibold text-[#8B1A1A] uppercase tracking-wide">Astronomic Information</h2>
                </div>
                <div class="px-5 py-2">
                    @foreach([
                        'Date of Birth'       => $member['horoscope']['dob'] ?? null,
                        'Birth Time'          => $member['horoscope']['birth_time'] ?? null,
                        'Birth City'          => $member['horoscope']['birth_city'] ?? null,
                        'Birth Place'         => $member['horoscope']['birth_place'] ?? null,
                        'Star (Natchathiram)' => $member['horoscope']['star'] ?? null,
                        'Rasi'                => $member['horoscope']['rasi'] ?? null,
                        'Nakshatra'           => $member['horoscope']['nakshatra'] ?? null,
                        'Padam'               => $member['horoscope']['padam'] ?? null,
                        'Lakknam'             => $member['horoscope']['lakknam'] ?? null,
                        'Paksha'              => $member['horoscope']['paksha'] ?? null,
                        'Tithi'               => $member['horoscope']['tithi'] ?? null,
                        'Ganam'               => $member['horoscope']['ganam'] ?? null,
                        'Nadi'                => $member['horoscope']['nadi'] ?? null,
                        'Dosham'              => $member['horoscope']['dosham'] ?? null,
                        'Horoscope Matching'  => $member['horoscope']['horoscope_matching'] ?? null,
                        'Directional Balance' => $member['horoscope']['directional_balance'] ?? null,
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
                    $box = (array)$box;
                    $type = $box['type'] ?? 'ZODIAC';
                    $bn = $box['box_number'] ?? 0;
                    $val = $box['value'] ?? '';
                    if(!isset($grid[$type][$bn])) $grid[$type][$bn] = [];
                    if($val) $grid[$type][$bn][] = $val;
                }
                $getBox = function($grid, $type, $bn) {
                    $items = $grid[$type][$bn] ?? [];
                    if(empty($items)) return '&nbsp;';
                    return implode(' | ', array_filter($items)) ?: '&nbsp;';
                };
            @endphp
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4">
                <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 rounded-t-2xl">
                    <h2 class="text-sm font-semibold text-[#8B1A1A] uppercase tracking-wide">Rasi Chart</h2>
                </div>
                <div class="p-3 overflow-x-auto">
                    <table class="w-full border-collapse text-xs" style="min-width:280px">
                        <tbody>
                            <tr>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em;width:25%">{!! $getBox($grid, 'ZODIAC', 1) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em;width:25%">{!! $getBox($grid, 'ZODIAC', 2) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em;width:25%">{!! $getBox($grid, 'ZODIAC', 3) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em;width:25%">{!! $getBox($grid, 'ZODIAC', 4) !!}</td>
                            </tr>
                            <tr>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid, 'ZODIAC', 5) !!}</td>
                                <td class="border-2 border-green-300 p-2 text-center bg-yellow-50 font-semibold text-gray-600 align-middle" colspan="2" rowspan="2">ZODIAC</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid, 'ZODIAC', 6) !!}</td>
                            </tr>
                            <tr>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid, 'ZODIAC', 7) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid, 'ZODIAC', 8) !!}</td>
                            </tr>
                            <tr>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid, 'ZODIAC', 9) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid, 'ZODIAC', 10) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid, 'ZODIAC', 11) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid, 'ZODIAC', 12) !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4">
                <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 rounded-t-2xl">
                    <h2 class="text-sm font-semibold text-[#8B1A1A] uppercase tracking-wide">Navamsa Chart</h2>
                </div>
                <div class="p-3 overflow-x-auto">
                    <table class="w-full border-collapse text-xs" style="min-width:280px">
                        <tbody>
                            <tr>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em;width:25%">{!! $getBox($grid, 'FEATURE', 1) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em;width:25%">{!! $getBox($grid, 'FEATURE', 2) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em;width:25%">{!! $getBox($grid, 'FEATURE', 3) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em;width:25%">{!! $getBox($grid, 'FEATURE', 4) !!}</td>
                            </tr>
                            <tr>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid, 'FEATURE', 5) !!}</td>
                                <td class="border-2 border-green-300 p-2 text-center bg-yellow-50 font-semibold text-gray-600 align-middle" colspan="2" rowspan="2">FEATURE</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid, 'FEATURE', 6) !!}</td>
                            </tr>
                            <tr>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid, 'FEATURE', 7) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" colspan="2" style="height:5.5em">{!! $getBox($grid, 'FEATURE', 8) !!}</td>
                            </tr>
                            <tr>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid, 'FEATURE', 9) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid, 'FEATURE', 10) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid, 'FEATURE', 11) !!}</td>
                                <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:5.5em">{!! $getBox($grid, 'FEATURE', 12) !!}</td>
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
                    <h2 class="text-sm font-semibold text-[#8B1A1A] uppercase tracking-wide">Physical Attributes</h2>
                </div>
                <div class="px-5 py-2">
                    @foreach([
                        'Height'          => !empty($member['physical']['height']) ? $member['physical']['height'] . ' cm' : null,
                        'Weight'          => !empty($member['physical']['weight']) ? $member['physical']['weight'] . ' kg' : null,
                        'Complexion'      => ucfirst($member['physical']['complexion'] ?? ''),
                        'Body Type'       => ucfirst(str_replace('_', ' ', $member['physical']['body_type'] ?? '')),
                        'Blood Group'     => $member['physical']['blood_group'] ?? null,
                        'Physical Status' => ucfirst($member['physical']['physical_status'] ?? ''),
                        'Eye Color'       => $member['physical']['eye_color'] ?? null,
                        'Hair Color'      => $member['physical']['hair_color'] ?? null,
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
                    <h2 class="text-sm font-semibold text-[#8B1A1A] uppercase tracking-wide">Education & Career</h2>
                </div>
                <div class="px-5 py-2">
                    @foreach([
                        'Education'      => ucwords(str_replace(['_', '/'], [' ', ' / '], $member['career']['education'] ?? '')),
                        'Study Details'  => $member['career']['study_details'] ?? null,
                        'Occupation'     => ucwords(str_replace('_', ' ', $member['career']['occupation'] ?? '')),
                        'Work Location'  => $member['career']['work_location'] ?? null,
                        'Income'         => ucfirst($member['career']['income'] ?? ''),
                        'Income Amount'  => !empty($member['career']['income_amount']) ? '₹' . number_format($member['career']['income_amount']) : null,
                        'Earnings Type'  => ucfirst($member['career']['earnings'] ?? ''),
                        'Career Profile' => $member['career']['career_profile'] ?? null,
                    ] as $label => $value)
                    <div class="flex py-2 border-b border-gray-50 last:border-0">
                        <span class="w-2/5 text-xs text-gray-500 font-medium uppercase tracking-wide pt-0.5">{{ $label }}</span>
                        <span class="w-3/5 text-sm text-gray-800 font-medium break-words">{{ $value ?: '—' }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- CONTACT TAB --}}
        <div x-show="tab === 'contact'">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4">
                <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 rounded-t-2xl">
                    <h2 class="text-sm font-semibold text-[#8B1A1A] uppercase tracking-wide">Contact & Address</h2>
                </div>
                <div class="px-5 py-2">
                    @foreach([
                        'Mobile'       => $member['contact']['mobile'] ?? null,
                        'Alternate No' => $member['contact']['alternate_number'] ?? null,
                        'Landline'     => $member['contact']['landline'] ?? null,
                        'Current City' => $member['contact']['current_city'] ?? null,
                        'Native Place' => $member['contact']['native_place'] ?? null,
                        'State'        => $member['contact']['state'] ?? null,
                        'Country'      => $member['contact']['country'] ?? null,
                        'Postal Code'  => $member['contact']['postal_code'] ?? null,
                        'Address'      => $member['contact']['address'] ?? null,
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
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4">
                <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 rounded-t-2xl">
                    <h2 class="text-sm font-semibold text-[#8B1A1A] uppercase tracking-wide">Family Information</h2>
                </div>
                <div class="px-5 py-2">
                    @php $fam = is_array($member['family'] ?? []) ? ($member['family'] ?? []) : (array)$member['family']; @endphp
                    @foreach([
                        'Father Name'      => $fam['father_name'] ?? $fam['father'] ?? null,
                        'Mother Name'      => $fam['mother_name'] ?? $fam['mother'] ?? null,
                        'Family Type'      => ucfirst($fam['family_type'] ?? ''),
                        'No. of Brothers'  => $fam['number_of_brothers'] ?? $fam['Number_of_brothers'] ?? null,
                        'Married Brothers' => $fam['married_brothers'] ?? $fam['Number_of_married_brothers'] ?? null,
                        'No. of Sisters'   => $fam['number_of_sisters'] ?? $fam['Number_of_Sisters'] ?? null,
                        'Married Sisters'  => $fam['married_sisters'] ?? $fam['Number_of_married_sisters'] ?? null,
                        'Property'         => $fam['property_description'] ?? $fam['Property_Description'] ?? null,
                        'Gothram'          => $fam['gothram'] ?? null,
                        'Surname'          => $fam['surname'] ?? $fam['Surname'] ?? null,
                    ] as $label => $value)
                    <div class="flex py-2 border-b border-gray-50 last:border-0">
                        <span class="w-2/5 text-xs text-gray-500 font-medium uppercase tracking-wide pt-0.5">{{ $label }}</span>
                        <span class="w-3/5 text-sm text-gray-800 font-medium break-words">{{ $value ?: '—' }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- PARTNER PREF TAB --}}
        <div x-show="tab === 'partner'">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4">
                <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 rounded-t-2xl">
                    <h2 class="text-sm font-semibold text-[#8B1A1A] uppercase tracking-wide">Partner Expectations</h2>
                </div>
                <div class="px-5 py-2">
                    @php $pp = is_array($member['partner_preference'] ?? []) ? ($member['partner_preference'] ?? []) : (array)$member['partner_preference']; @endphp
                    @foreach([
                        'Preferred Age'  => $pp['preferred_age'] ?? $pp['partner_age'] ?? null,
                        'Height'         => $pp['preferred_height'] ?? $pp['partner_height'] ?? null,
                        'Weight'         => $pp['preferred_weight'] ?? $pp['partner_weight'] ?? null,
                        'Education'      => ucwords(str_replace(['_', '/'], [' ', ' / '], $pp['education'] ?? $pp['partner_education'] ?? '')),
                        'Occupation'     => ucwords(str_replace('_', ' ', $pp['occupation'] ?? $pp['partner_profession'] ?? '')),
                        'Marital Status' => ucwords(str_replace('_', ' ', $pp['marital_status'] ?? $pp['partner_marital_status'] ?? '')),
                        'Caste'          => $pp['caste'] ?? null,
                        'Dosham'         => $pp['dosham'] ?? $pp['partner_DOSHAM'] ?? null,
                        'Body Type'      => ucfirst($pp['body_type'] ?? $pp['partner_body_type'] ?? ''),
                        'About Partner'  => $pp['about_partner'] ?? $pp['partner_Expectation'] ?? null,
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
    @endif

</div>

<script>
function sendInterest(memberId, profileId) {
    fetch(`/members/${memberId}/interest`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
        body: JSON.stringify({ profile_id: profileId })
    }).then(r => r.json()).then(d => alert(d.message)).catch(() => alert('Something went wrong.'));
}
function shortlistMember(memberId, profileId) {
    fetch(`/members/${memberId}/shortlist`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
        body: JSON.stringify({ profile_id: profileId })
    }).then(r => r.json()).then(d => alert(d.message)).catch(() => alert('Something went wrong.'));
}
function blockMember(memberId, profileId) {
    if (!confirm('Are you sure you want to block this member?')) return;
    fetch(`/members/${memberId}/block`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
        body: JSON.stringify({ profile_id: profileId })
    }).then(r => r.json()).then(d => alert(d.message)).catch(() => alert('Something went wrong.'));
}
</script>
@endsection

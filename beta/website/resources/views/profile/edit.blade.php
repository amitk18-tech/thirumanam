@extends('layouts.app')

@section('title', __('ui.pe_title') . ' — Thirumanam')

@section('content')
<div class="min-h-screen bg-gray-50" x-data="profileEdit()">

  <div class="bg-red-900 text-white py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <h1 class="text-2xl font-bold">{{ __('ui.pe_title') }}</h1>
      <p class="text-red-200 text-sm mt-1">{{ __('ui.pe_subtitle') }}</p>
    </div>
  </div>

  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div x-show="success" x-cloak class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm" x-text="success"></div>
    <div x-show="error" x-cloak class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-600 text-sm" x-text="error"></div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

      <div class="flex overflow-x-auto border-b border-gray-100">
        @foreach([
            'basic' => __('ui.pe_tab_basic'),
            'horoscope' => __('ui.pe_tab_horoscope'),
            'physical' => __('ui.pe_tab_physical'),
            'career' => __('ui.pe_tab_career'),
            'contact' => __('ui.pe_tab_contact'),
            'security' => __('ui.pe_tab_security'),
            'family'   => __('ui.pe_tab_family'),
            'partner'  => __('ui.pe_tab_partner'),
        ] as $key => $label)
          <button type="button" @click="tab = '{{ $key }}'"
                  :class="tab === '{{ $key }}' ? 'border-b-2 border-red-800 text-red-800 font-semibold' : 'text-gray-500 hover:text-gray-700'"
                  class="px-5 py-4 text-sm whitespace-nowrap transition">
            {{ $label }}
          </button>
        @endforeach
      </div>

      <form @submit.prevent="save" class="p-6">

        {{-- Basic --}}
        <div x-show="tab === 'basic'" class="space-y-4">
            
            {{-- Photo Upload --}}
          <div class="flex items-center gap-6">
            <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-100 border border-gray-300 flex items-center justify-center">
              <img id="photoPreview"
                src="{{ $profile['profile_photo'] ? (str_starts_with($profile['profile_photo'], 'http') ? $profile['profile_photo'] : 'https://api.thirumanam.info/' . $profile['profile_photo']) : 'https://ui-avatars.com/api/?name=' . urlencode($profile['name'] ?? 'User') }}"
                class="w-full h-full object-cover">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_profile_photo') }}</label>
              <input type="file" id="photoInput" accept="image/*" class="text-sm text-gray-600"
                onchange="previewPhoto(this)">
              <button type="button" onclick="uploadPhoto()"
                class="mt-2 px-4 py-1.5 bg-[#8B1A1A] text-white text-sm rounded hover:bg-[#6e1414]">
                {{ __('ui.pe_upload_photo') }}
              </button>
              <p id="photoStatus" class="text-xs mt-1 text-gray-500"></p>
            </div>
          </div>
          
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="label">{{ __('ui.ms_label_gender') }}</label>
              <select x-model="form.gender" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="male">{{ __('ui.pe_opt_male') }}</option>
                <option value="female">{{ __('ui.pe_opt_female') }}</option>
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_dob') }}</label>
              <input type="date" x-model="form.dob" class="input">
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_marital_status') }}</label>
              <select x-model="form.marital_status" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="never_married">{{ __('ui.never_married') }}</option>
                <option value="divorced">{{ __('ui.divorced') }}</option>
                <option value="widowed">{{ __('ui.widowed') }}</option>
                <option value="separated">{{ __('ui.separated') }}</option>
              </select>
            </div>
            <div x-show="form.marital_status !== 'never_married'">
              <label class="label">{{ __('ui.pe_label_number_of_children') }}</label>
              <input type="number" x-model="form.number_of_children" class="input" min="0" placeholder="0">
            </div>
            <div x-show="form.marital_status !== 'never_married'">
              <label class="label">{{ __('ui.pe_label_children_living_place') }}</label>
              <select x-model="form.children_living_place" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="living_with_me">{{ __('ui.pe_opt_living_with_me') }}</option>
                <option value="not_living_with_me">{{ __('ui.pe_opt_not_living_with_me') }}</option>
              </select>
            </div>
          </div>
          <div>
            <label class="label">{{ __('ui.pe_label_introduction') }}</label>
            <textarea x-model="form.introduction" rows="4" class="input" placeholder="{{ __('ui.pe_ph_introduction') }}"></textarea>
          </div>
        </div>

        {{-- Horoscope --}}
        <div x-show="tab === 'horoscope'" class="space-y-4">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="label">{{ __('ui.ms_label_star') }}</label>
              <select x-model="form.star" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                @foreach(['Ashwini','Bharani','Krittika','Rohini','Mrigashira','Ardra','Punarvasu','Pushya','Ashlesha','Magha','Purva Phalguni','Uttara Phalguni','Hasta','Chitra','Swati','Vishakha','Anuradha','Jyeshtha','Mula','Purva Ashadha','Uttara Ashadha','Shravana','Dhanishtha','Shatabhisha','Purva Bhadrapada','Uttara Bhadrapada','Revati'] as $s)
                  <option value="{{ $s }}">{{ tv('star', $s) }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_rasi') }}</label>
              <select x-model="form.rasi" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                @foreach(['Mesha','Rishabha','Mithuna','Kataka','Simha','Kanya','Tula','Vrischika','Dhanus','Makara','Kumbha','Meena'] as $r)
                  <option value="{{ $r }}">{{ tv('rasi', $r) }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_paksha') }}</label>
              <select x-model="form.paksha" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="shukla">{{ __('ui.pe_opt_shukla') }}</option>
                <option value="krishna">{{ __('ui.pe_opt_krishna') }}</option>
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_tithi') }}</label>
              <input type="text" x-model="form.tithi" class="input" placeholder="{{ __('ui.pe_ph_tithi') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_ganam') }}</label>
              <select x-model="form.ganam" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="dev">{{ __('ui.pe_opt_dev') }}</option>
                <option value="manush">{{ __('ui.pe_opt_manush') }}</option>
                <option value="rakshas">{{ __('ui.pe_opt_rakshas') }}</option>
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_nadi') }}</label>
              <select x-model="form.nadi" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="adi">{{ __('ui.pe_opt_adi') }}</option>
                <option value="madhya">{{ __('ui.pe_opt_madhya') }}</option>
                <option value="antya">{{ __('ui.pe_opt_antya') }}</option>
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_dosham') }}</label>
              <select x-model="form.dosham" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="no">{{ __('ui.pe_opt_no') }}</option>
                <option value="yes">{{ __('ui.pe_opt_yes') }}</option>
                <option value="partial">{{ __('ui.pe_opt_partial') }}</option>
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_type_of_dosham') }}</label>
              <input type="text" x-model="form.type_of_dosham" class="input" placeholder="{{ __('ui.pe_ph_type_of_dosham') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_horoscope_matching') }}</label>
              <select x-model="form.horoscope_matching" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="yes">{{ __('ui.pe_opt_yes') }}</option>
                <option value="no">{{ __('ui.pe_opt_no') }}</option>
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_birth_time') }}</label>
              <input type="time" x-model="form.birth_time" class="input">
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_birth_city') }}</label>
              <input type="text" x-model="form.birth_city" class="input" placeholder="{{ __('ui.pe_ph_birth_city') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_birth_place') }}</label>
              <input type="text" x-model="form.birth_place" class="input" placeholder="{{ __('ui.pe_ph_birth_place') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_birth_country') }}</label>
              <input type="text" x-model="form.birth_country" class="input" placeholder="{{ __('ui.pe_ph_birth_country') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_birth_state') }}</label>
              <input type="text" x-model="form.birth_state" class="input" placeholder="{{ __('ui.pe_ph_birth_state') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_lakknam') }}</label>
              <input type="text" x-model="form.lakknam" class="input" placeholder="{{ __('ui.pe_ph_lakknam') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_directional_balance') }}</label>
              <input type="text" x-model="form.directional_balance" class="input" placeholder="{{ __('ui.pe_ph_directional_balance') }}">
            </div>
          </div>

          {{-- Horoscope Chart Grids --}}
          @php
            $bGrid = ['ZODIAC' => [], 'FEATURE' => []];
            foreach($horoscope_boxes as $hb) {
                $hb = (array)$hb;
                $t = $hb['type'] ?? 'ZODIAC';
                $bn = $hb['box_number'] ?? 0;
                $bGrid[$t][$bn][] = ['id' => $hb['id'] ?? null, 'value' => $hb['value'] ?? ''];
            }
            $chartTypes = ['ZODIAC' => __('ui.pe_chart_rasi'), 'FEATURE' => __('ui.pe_chart_feature')];
            $chartTypeLabels = ['ZODIAC' => __('ui.ms_zodiac'), 'FEATURE' => __('ui.ms_feature')];
          @endphp
          @foreach($chartTypes as $chartType => $chartLabel)
          <div class="mt-6">
            <h3 class="text-sm font-semibold text-[#8B1A1A] uppercase tracking-wide mb-2">{{ $chartLabel }}</h3>
            <div class="overflow-x-auto">
              <table class="w-full border-collapse text-xs" style="min-width:280px">
                <tbody>
                  @foreach([[1,2,3,4],[5,null,null,6],[null,7,8,null],[9,10,11,12]] as $rowIdx => $row)
                  <tr>
                    @foreach($row as $colIdx => $bn)
                      @if($rowIdx==1 && $colIdx==1)
                        <td class="border-2 border-green-300 bg-yellow-50 text-center font-semibold text-gray-500 align-middle" colspan="2" rowspan="2" style="height:5.5em">{{ $chartTypeLabels[$chartType] }}</td>
                      @elseif(($rowIdx==1 && $colIdx==2) || ($rowIdx==2 && $colIdx==0) || ($rowIdx==2 && $colIdx==3))
                        {{-- skip colspan/rowspan cells --}}
                      @elseif($bn !== null)
                        @php
                          $existing = $bGrid[$chartType][$bn] ?? [];
                          $planets = ['', 'SUN', 'MOON', 'MARS', 'MERCURY', 'JUPITER', 'VENUS', 'SATURN', 'RAGU', 'KETHU', 'MANTHU', 'LAKKNAM'];
                          $cellVal = '';
                        @endphp
                        <td class="border-2 border-green-300 p-1 align-top bg-green-50" style="height:8em;width:25%;overflow-y:auto">
                          <div class="text-[10px] text-gray-400 mb-0.5">{{ $bn }}</div>
                          <div class="grid grid-cols-2 gap-0.5">
                          @for($slot = 1; $slot <= 6; $slot++)
                            @php $slotVal = $existing[$slot-1]['value'] ?? ''; @endphp
                            <select class="w-full text-[10px] mb-0.5 bg-transparent border-b border-green-200 outline-none" data-box="{{ $bn }}" data-type="{{ $chartType }}" data-slot="{{ $slot }}">
                              @foreach($planets as $p)
                                <option value="{{ $p }}" {{ $slotVal === $p ? 'selected' : '' }}>{{ $p ?: '—' }}</option>
                              @endforeach
                            </select>
                          @endfor
                          </div>
                        </td>
                      @endif
                    @endforeach
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          @endforeach
          <div class="mt-3 flex items-center gap-3">
            <button type="button" onclick="saveHoroscopeBoxes(this)" class="px-4 py-2 bg-[#8B1A1A] text-white text-sm rounded-lg hover:bg-red-800">{{ __('ui.pe_save_charts') }}</button>
            <span id="hbox-msg" class="text-sm"></span>
          </div>
        </div>

        {{-- Physical --}}
        <div x-show="tab === 'physical'" class="space-y-4">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="label">{{ __('ui.ms_label_height') }} (cm)</label>
              <input type="number" x-model="form.height" class="input" placeholder="{{ __('ui.pe_ph_height') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_weight') }} (kg)</label>
              <input type="number" x-model="form.weight" class="input" placeholder="{{ __('ui.pe_ph_weight') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_complexion') }}</label>
              <select x-model="form.complexion" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="fair">{{ __('ui.pe_opt_fair') }}</option>
                <option value="wheatish">{{ __('ui.pe_opt_wheatish') }}</option>
                <option value="dark">{{ __('ui.pe_opt_dark') }}</option>
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_body_type') }}</label>
              <select x-model="form.body_type" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="slim">{{ __('ui.pe_opt_slim') }}</option>
                <option value="athletic">{{ __('ui.pe_opt_athletic') }}</option>
                <option value="average">{{ __('ui.pe_opt_average') }}</option>
                <option value="heavy">{{ __('ui.pe_opt_heavy') }}</option>
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_blood_group') }}</label>
              <select x-model="form.blood_group" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                @foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $bg)
                  <option value="{{ $bg }}">{{ $bg }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_physical_status') }}</label>
              <select x-model="form.physical_status" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="normal">{{ __('ui.pe_opt_normal') }}</option>
                <option value="differently_abled">{{ __('ui.pe_opt_differently_abled') }}</option>
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_eye_color') }}</label>
              <input type="text" x-model="form.eye_color" class="input" placeholder="{{ __('ui.pe_ph_eye_color') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_hair_color') }}</label>
              <input type="text" x-model="form.hair_color" class="input" placeholder="{{ __('ui.pe_ph_hair_color') }}">
            </div>
          </div>
        </div>

        {{-- Career --}}
        <div x-show="tab === 'career'" class="space-y-4">
          @if($isLocked)
          <div class="mb-4 p-3 bg-amber-50 border border-amber-300 rounded-lg text-amber-800 text-sm font-medium">⚠️ {{ __("ui.pe_lock_message") }}</div>
          @endif
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="label">{{ __('ui.ms_label_education') }}</label>
              <input type="text" x-model="form.education" class="input" placeholder="{{ __('ui.pe_ph_education') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_study_details') }}</label>
              <input type="text" x-model="form.study_details" class="input" placeholder="{{ __('ui.pe_ph_study_details') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_occupation') }}</label>
              <input type="text" x-model="form.occupation" class="input" placeholder="{{ __('ui.pe_ph_occupation') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_work_location') }}</label>
              <input type="text" x-model="form.work_location" class="input" placeholder="{{ __('ui.pe_ph_work_location') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_income_level') }}</label>
              <select x-model="form.income" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="low">{{ __('ui.pe_opt_low') }}</option>
                <option value="medium">{{ __('ui.pe_opt_medium') }}</option>
                <option value="high">{{ __('ui.pe_opt_high') }}</option>
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_income_amount') }} (monthly)</label>
              <input type="number" x-model="form.income_amount" class="input" placeholder="{{ __('ui.pe_ph_income_amount') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_earnings_type') }}</label>
              <select x-model="form.earnings" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="monthly">{{ __('ui.pe_opt_monthly') }}</option>
                <option value="yearly">{{ __('ui.pe_opt_yearly') }}</option>
              </select>
            </div>
          </div>
          <div>
            <label class="label">{{ __('ui.ms_label_career_profile') }}</label>
            <textarea x-model="form.career_profile" rows="3" class="input" placeholder="{{ __('ui.pe_ph_career_profile') }}"></textarea>
          </div>
        </div>

        {{-- Contact --}}
        <div x-show="tab === 'contact'" class="space-y-4">
          @if($isLocked)
          <div class="mb-4 p-3 bg-amber-50 border border-amber-300 rounded-lg text-amber-800 text-sm font-medium">⚠️ {{ __("ui.pe_lock_message") }}</div>
          @endif
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="label">{{ __('ui.ms_label_city') }}</label>
              <input type="text" x-model="form.city" class="input" placeholder="{{ __('ui.pe_ph_city') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_current_city') }}</label>
              <input type="text" x-model="form.current_city" class="input" placeholder="{{ __('ui.pe_ph_current_city') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_state') }}</label>
              <input type="text" x-model="form.state" class="input" placeholder="{{ __('ui.pe_ph_state') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_country') }}</label>
              <input type="text" x-model="form.country" class="input" placeholder="{{ __('ui.pe_ph_country') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_native_place') }}</label>
              <input type="text" x-model="form.native_place" class="input" placeholder="{{ __('ui.pe_ph_native_place') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_postal_code') }}</label>
              <input type="text" x-model="form.postal_code" class="input" placeholder="{{ __('ui.pe_ph_postal_code') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_mobile') }}</label>
              <input type="text" value="{{ $user['profile']['user']['phone'] ?? $profile['mobile'] ?? '' }}" class="input bg-gray-100 cursor-not-allowed" readonly disabled>
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_alternate_number') }}</label>
              <input type="text" x-model="form.alternate_number" class="input">
            </div>
            <div>
              <label class="label">{{ __('ui.ms_label_landline') }}</label>
              <input type="text" x-model="form.landline" class="input" placeholder="{{ __('ui.pe_ph_landline') }}">
            </div>
          </div>
          <div>
            <label class="label">{{ __('ui.ms_label_address') }}</label>
            <textarea x-model="form.address" rows="3" class="input" placeholder="{{ __('ui.pe_ph_address') }}"></textarea>
          </div>
        </div>

        {{-- Family --}}
        <div x-show="tab === 'family'" class="space-y-4">
          @if($isLocked)
          <div class="mb-4 p-3 bg-amber-50 border border-amber-300 rounded-lg text-amber-800 text-sm font-medium">⚠️ {{ __("ui.pe_lock_message") }}</div>
          @endif
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="label">{{ __('ui.pe_label_surname') }}</label>
              <input type="text" x-model="familyForm.surname" class="input" placeholder="{{ __('ui.pe_ph_surname') }}">
            </div>

            <div>
              <label class="label">{{ __('ui.pe_label_father_name') }}</label>
              <input type="text" x-model="familyForm.father_name" class="input" placeholder="{{ __('ui.pe_ph_father_name') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_father_occupation') }}</label>
              <input type="text" x-model="familyForm.father_occupation" class="input" placeholder="{{ __('ui.pe_ph_father_occupation') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_mother_name') }}</label>
              <input type="text" x-model="familyForm.mother_name" class="input" placeholder="{{ __('ui.pe_ph_mother_name') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_mother_occupation') }}</label>
              <input type="text" x-model="familyForm.mother_occupation" class="input" placeholder="{{ __('ui.pe_ph_mother_occupation') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_father_vangusam') }}</label>
              <input type="text" x-model="familyForm.father_vangusam" class="input" placeholder="{{ __('ui.pe_ph_father_vangusam') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_mother_vangusam') }}</label>
              <input type="text" x-model="familyForm.mother_vangusam" class="input" placeholder="{{ __('ui.pe_ph_mother_vangusam') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_brothers_count') }}</label>
              <input type="number" x-model="familyForm.brothers_count" class="input" min="0" placeholder="0">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_brothers_married') }}</label>
              <input type="number" x-model="familyForm.brothers_married" class="input" min="0" placeholder="0">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_sisters_count') }}</label>
              <input type="number" x-model="familyForm.sisters_count" class="input" min="0" placeholder="0">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_sisters_married') }}</label>
              <input type="number" x-model="familyForm.sisters_married" class="input" min="0" placeholder="0">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_family_status') }}</label>
              <select x-model="familyForm.family_status" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="middle class">{{ __('ui.pe_opt_middle_class') }}</option>
                <option value="upper">{{ __('ui.pe_opt_upper') }}</option>
                <option value="rich">{{ __('ui.pe_opt_rich') }}</option>
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_family_type') }}</label>
              <select x-model="familyForm.family_type" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="joint">{{ __('ui.pe_opt_joint') }}</option>
                <option value="nuclear">{{ __('ui.pe_opt_nuclear') }}</option>
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_family_values') }}</label>
              <select x-model="familyForm.family_values" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="traditional">{{ __('ui.pe_opt_traditional') }}</option>
                <option value="modern">{{ __('ui.pe_opt_modern') }}</option>
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_soveran_details') }}</label>
              <input type="number" x-model="familyForm.soveran_details" class="input" min="0" placeholder="0">
            </div>
          </div>
          <div>
            <label class="label">{{ __('ui.pe_label_about_family') }}</label>
            <textarea x-model="familyForm.about_family" rows="3" class="input" placeholder="{{ __('ui.pe_ph_about_family') }}"></textarea>
          </div>
          <div>
            <label class="label">{{ __('ui.pe_label_property_description') }}</label>
            <textarea x-model="familyForm.property_description" rows="3" class="input" placeholder="{{ __('ui.pe_ph_property_description') }}"></textarea>
          </div>
          <div x-show="familySuccess" x-cloak class="p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm" x-text="familySuccess"></div>
          <div x-show="familyError" x-cloak class="p-3 bg-red-50 border border-red-200 rounded-lg text-red-600 text-sm" x-text="familyError"></div>
          <div class="flex justify-end">
            <button type="button" @click="saveFamily" :disabled="familyLoading @if($isLocked) || true @endif"
                    class="bg-red-800 hover:bg-red-900 text-white px-8 py-3 rounded-lg font-semibold transition disabled:opacity-50">
              <span x-show="!familyLoading">{{ __('ui.pe_save_changes') }}</span>
              <span x-show="familyLoading">{{ __('ui.pe_saving') }}</span>
            </button>
          </div>
        </div>

        {{-- Partner Preference --}}
        <div x-show="tab === 'partner'" class="space-y-4">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="label">{{ __('ui.pe_label_preferred_age_min') }}</label>
              <input type="number" x-model="partnerForm.preferred_age_min" class="input" min="18" placeholder="{{ __('ui.pe_ph_preferred_age_min') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_preferred_age_max') }}</label>
              <input type="number" x-model="partnerForm.preferred_age_max" class="input" min="18" placeholder="{{ __('ui.pe_ph_preferred_age_max') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_preferred_height_min') }}</label>
              <input type="number" x-model="partnerForm.preferred_height_min" class="input" min="50" placeholder="{{ __('ui.pe_ph_preferred_height_min') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_preferred_height_max') }}</label>
              <input type="number" x-model="partnerForm.preferred_height_max" class="input" min="50" placeholder="{{ __('ui.pe_ph_preferred_height_max') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_partner_marital_status') }}</label>
              <select x-model="partnerForm.marital_status" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="never_married">{{ __('ui.never_married') }}</option>
                <option value="divorced">{{ __('ui.divorced') }}</option>
                <option value="widowed">{{ __('ui.widowed') }}</option>
                <option value="separated">{{ __('ui.separated') }}</option>
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_children_acceptables') }}</label>
              <select x-model="partnerForm.children_acceptables" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="yes">{{ __('ui.pe_opt_yes') }}</option>
                <option value="no">{{ __('ui.pe_opt_no') }}</option>
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_partner_religion') }}</label>
              <input type="text" x-model="partnerForm.religion" class="input" placeholder="{{ __('ui.pe_ph_partner_religion') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_partner_caste') }}</label>
              <input type="text" x-model="partnerForm.caste" class="input" placeholder="{{ __('ui.pe_ph_partner_caste') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_partner_education') }}</label>
              <input type="text" x-model="partnerForm.education" class="input" placeholder="{{ __('ui.pe_ph_partner_education') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_partner_occupation') }}</label>
              <input type="text" x-model="partnerForm.occupation" class="input" placeholder="{{ __('ui.pe_ph_partner_occupation') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_partner_profession') }}</label>
              <input type="text" x-model="partnerForm.profession" class="input" placeholder="{{ __('ui.pe_ph_partner_profession') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_partner_location') }}</label>
              <input type="text" x-model="partnerForm.location" class="input" placeholder="{{ __('ui.pe_ph_partner_location') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_partner_family_type') }}</label>
              <select x-model="partnerForm.family_type" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="joint">{{ __('ui.pe_opt_joint') }}</option>
                <option value="nuclear">{{ __('ui.pe_opt_nuclear') }}</option>
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_horoscope_required') }}</label>
              <select x-model="partnerForm.horoscope_required" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="1">{{ __('ui.pe_opt_yes') }}</option>
                <option value="0">{{ __('ui.pe_opt_no') }}</option>
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_horoscope_natchathiram') }}</label>
              <input type="text" x-model="partnerForm.horoscope_natchathiram" class="input" placeholder="{{ __('ui.pe_ph_horoscope_natchathiram') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_horoscope_rasi') }}</label>
              <input type="text" x-model="partnerForm.horoscope_rasi" class="input" placeholder="{{ __('ui.pe_ph_horoscope_rasi') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_partner_dosham') }}</label>
              <select x-model="partnerForm.dosham" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="no">{{ __('ui.pe_opt_no') }}</option>
                <option value="yes">{{ __('ui.pe_opt_yes') }}</option>
                <option value="partial">{{ __('ui.pe_opt_partial') }}</option>
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_partner_type_of_dosham') }}</label>
              <input type="text" x-model="partnerForm.type_of_dosham" class="input" placeholder="{{ __('ui.pe_ph_partner_type_of_dosham') }}">
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_drinking') }}</label>
              <select x-model="partnerForm.drinking" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="yes">{{ __('ui.pe_opt_yes') }}</option>
                <option value="no">{{ __('ui.pe_opt_no') }}</option>
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_smoking') }}</label>
              <select x-model="partnerForm.smoking" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="yes">{{ __('ui.pe_opt_yes') }}</option>
                <option value="no">{{ __('ui.pe_opt_no') }}</option>
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_partner_body_type') }}</label>
              <select x-model="partnerForm.body_type" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="slim">{{ __('ui.pe_opt_slim') }}</option>
                <option value="athletic">{{ __('ui.pe_opt_athletic') }}</option>
                <option value="average">{{ __('ui.pe_opt_average') }}</option>
                <option value="heavy">{{ __('ui.pe_opt_heavy') }}</option>
              </select>
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_partner_physical_status') }}</label>
              <select x-model="partnerForm.physical_status" class="input">
                <option value="">{{ __('ui.pe_opt_select') }}</option>
                <option value="normal">{{ __('ui.pe_opt_normal') }}</option>
                <option value="differently_abled">{{ __('ui.pe_opt_differently_abled') }}</option>
              </select>
            </div>
          </div>
          <div>
            <label class="label">{{ __('ui.pe_label_expectations') }}</label>
            <textarea x-model="partnerForm.expectations" rows="4" class="input" placeholder="{{ __('ui.pe_ph_expectations') }}"></textarea>
          </div>
          <div x-show="partnerSuccess" x-cloak class="p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm" x-text="partnerSuccess"></div>
          <div x-show="partnerError" x-cloak class="p-3 bg-red-50 border border-red-200 rounded-lg text-red-600 text-sm" x-text="partnerError"></div>
          <div class="flex justify-end">
            <button type="button" @click="savePartner" :disabled="partnerLoading"
                    class="bg-red-800 hover:bg-red-900 text-white px-8 py-3 rounded-lg font-semibold transition disabled:opacity-50">
              <span x-show="!partnerLoading">{{ __('ui.pe_save_changes') }}</span>
              <span x-show="partnerLoading">{{ __('ui.pe_saving') }}</span>
            </button>
          </div>
        </div>

        {{-- Security --}}
        <div x-show="tab === 'security'" class="space-y-4">
          <p class="text-sm text-gray-500">{{ __('ui.pe_security_desc') }}</p>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
            <div>
              <label class="label">{{ __('ui.pe_label_current_password') }}</label>
              <div class="relative">
                <input :type="showCurrent ? 'text' : 'password'" x-model="pwForm.current_password" class="input pr-10" placeholder="{{ __('ui.pe_ph_current_password') }}" autocomplete="new-password">
                <button type="button" @click="showCurrent = !showCurrent" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                  <i :class="showCurrent ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                </button>
              </div>
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_new_password') }}</label>
              <div class="relative">
                <input :type="showNew ? 'text' : 'password'" x-model="pwForm.new_password" class="input pr-10" placeholder="{{ __('ui.pe_ph_new_password') }}">
                <button type="button" @click="showNew = !showNew" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                  <i :class="showNew ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                </button>
              </div>
            </div>
            <div>
              <label class="label">{{ __('ui.pe_label_confirm_new_password') }}</label>
              <div class="relative">
                <input :type="showConfirm ? 'text' : 'password'" x-model="pwForm.new_password_confirmation" class="input pr-10" placeholder="{{ __('ui.pe_ph_confirm_new_password') }}">
                <button type="button" @click="showConfirm = !showConfirm" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                  <i :class="showConfirm ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                </button>
              </div>
            </div>
          </div>
          <div x-show="pwSuccess" x-cloak class="p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm" x-text="pwSuccess"></div>
          <div x-show="pwError" x-cloak class="p-3 bg-red-50 border border-red-200 rounded-lg text-red-600 text-sm" x-text="pwError"></div>
          <div class="flex justify-end">
            <button type="button" @click="changePassword" :disabled="pwLoading"
                    class="bg-red-800 hover:bg-red-900 text-white px-8 py-3 rounded-lg font-semibold transition disabled:opacity-50">
              <span x-show="!pwLoading">{{ __('ui.pe_change_password') }}</span>
              <span x-show="pwLoading">{{ __('ui.pe_saving') }}</span>
            </button>
          </div>
        </div>

        <div x-show="tab !== 'security' && tab !== 'family' && tab !== 'partner'" class="mt-6 flex justify-end">
          <button type="submit" :disabled="loading @if($isLocked) || ['career','contact'].includes(tab) @endif"
                  class="bg-red-800 hover:bg-red-900 text-white px-8 py-3 rounded-lg font-semibold transition disabled:opacity-50">
            <span x-show="!loading">{{ __('ui.pe_save_changes') }}</span>
            <span x-show="loading">{{ __('ui.pe_saving') }}</span>
          </button>
        </div>

      </form>
    </div>
  </div>
</div>

<style>
.label { display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem; }
.input { width: 100%; border: 1px solid #D1D5DB; border-radius: 0.5rem; padding: 0.5rem 0.75rem; font-size: 0.875rem; }
.input:focus { outline: none; box-shadow: 0 0 0 2px #ef4444; }
</style>

<script>
const peI18n = {
  profileIdNotFound: @json(__('ui.pe_js_profile_id_not_found')),
  chartsSaved:       @json(__('ui.pe_js_charts_saved')),
  chartsSaveFailed:  @json(__('ui.pe_js_charts_save_failed')),
  selectPhotoFirst:  @json(__('ui.pe_js_select_photo_first')),
  uploading:         @json(__('ui.pe_js_uploading')),
  photoUploaded:     @json(__('ui.pe_js_photo_uploaded')),
  uploadFailed:      @json(__('ui.pe_js_upload_failed')),
  uploadError:       @json(__('ui.pe_js_upload_error')),
  somethingWrong:    @json(__('ui.pe_js_something_wrong')),
  updateFailed:      @json(__('ui.pe_js_update_failed')),
  updateSuccess:     @json(__('ui.pe_js_update_success')),
  saving:            @json(__('ui.pe_saving')),
};

function profileEdit() {
  return {
    tab: 'basic',
    loading: false,
    pwLoading: false,
    pwSuccess: '',
    pwError: '',
    pwForm: { current_password: '', new_password: '', new_password_confirmation: '' },
    success: '',
    error: '',
    form: {
      gender:               '{{ $profile['gender'] ?? '' }}',
      dob:                  '{{ $profile["date_of_birth"] ?? $profile["dob"] ?? '' }}',
      marital_status:       '{{ $profile['marital_status'] ?? '' }}',
      number_of_children:   '{{ $profile['number_of_children'] ?? '' }}',
      children_living_place:'{{ $profile['children_living_place'] ?? '' }}',
      introduction:         @json($profile['introduction'] ?? ''),
      star:                 '{{ $profile['star'] ?? '' }}',
      rasi:                 '{{ $profile['rasi'] ?? '' }}',
      paksha:               '{{ $profile['paksha'] ?? '' }}',
      tithi:                '{{ $profile['tithi'] ?? '' }}',
      ganam:                '{{ $profile['ganam'] ?? '' }}',
      nadi:                 '{{ $profile['nadi'] ?? '' }}',
      dosham:               '{{ $profile['dosham'] ?? '' }}',
      type_of_dosham:       '{{ $profile['type_of_dosham'] ?? '' }}',
      horoscope_matching:   '{{ $profile['horoscope_matching'] ?? '' }}',
      birth_time:           '{{ $profile['birth_time'] ?? '' }}',
      birth_city:           '{{ $profile['birth_city'] ?? '' }}',
      birth_place:          '{{ $profile['birth_place'] ?? '' }}',
      birth_country:        '{{ $profile['birth_country'] ?? '' }}',
      birth_state:          '{{ $profile['birth_state'] ?? '' }}',
      lakknam:              '{{ $profile['lakknam'] ?? '' }}',
      directional_balance:  '{{ $profile['directional_balance'] ?? '' }}',
      height:               '{{ $profile['height'] ?? '' }}',
      weight:               '{{ $profile['weight'] ?? '' }}',
      complexion:           '{{ $profile['complexion'] ?? '' }}',
      body_type:            '{{ $profile['body_type'] ?? '' }}',
      blood_group:          '{{ $profile['blood_group'] ?? '' }}',
      physical_status:      '{{ $profile['physical_status'] ?? '' }}',
      eye_color:            '{{ $profile['eye_color'] ?? '' }}',
      hair_color:           '{{ $profile['hair_color'] ?? '' }}',
      education:            '{{ $profile['education'] ?? '' }}',
      study_details:        '{{ $profile['study_details'] ?? '' }}',
      occupation:           '{{ $profile['occupation'] ?? '' }}',
      work_location:        '{{ $profile['work_location'] ?? '' }}',
      income:               '{{ $profile['income'] ?? '' }}',
      income_amount:        '{{ $profile['income_amount'] ?? '' }}',
      earnings:             '{{ $profile['earnings'] ?? '' }}',
      career_profile:       @json($profile['career_profile'] ?? ''),
      city:                 '{{ $profile['city'] ?? '' }}',
      current_city:         '{{ $profile['current_city'] ?? '' }}',
      state:                '{{ $profile['state'] ?? '' }}',
      country:              '{{ $profile['country'] ?? '' }}',
      native_place:         '{{ $profile['native_place'] ?? '' }}',
      postal_code:          '{{ $profile['postal_code'] ?? '' }}',
      mobile:               '{{ $profile['mobile'] ?? '' }}',
      alternate_number:     '{{ $profile['alternate_number'] ?? '' }}',
      landline:             '{{ $profile['landline'] ?? '' }}',
      address:              @json($profile['address'] ?? ''),
    },

    async save() {
      this.success = '';
      this.error = '';
      this.loading = true;
      try {
        const res = await fetch('/profile/update', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          },
          body: JSON.stringify({
            ...this.form,
            date_of_birth: this.form.dob,
            height: this.form.height ? parseInt(this.form.height) : null,
            weight: this.form.weight ? parseInt(this.form.weight) : null,
            earnings: this.form.earnings === 'monthly' ? 'month' : (this.form.earnings === 'yearly' ? 'year' : this.form.earnings),
          }),
        });
        const data = await res.json();
        if (data.success) {
          // Also save horoscope charts if on horoscope tab
          if (this.tab === 'horoscope') {
            const saveBtn = document.querySelector('[onclick="saveHoroscopeBoxes(this)"]');
            if (saveBtn) await saveHoroscopeBoxes(saveBtn);
          }
          this.success = data.message ?? peI18n.updateSuccess;
          window.scrollTo(0, 0);
          setTimeout(() => { window.location.href = '/profile/me'; }, 1000);
        } else {
          this.error = data.message ?? peI18n.updateFailed;
        }
      } catch (e) {
        this.error = peI18n.somethingWrong;
      }
      this.loading = false;
    },

    familyLoading: false,
    familySuccess: '',
    familyError: '',
    familyForm: {
      surname: '', father_name: '', father_occupation: '',
      mother_name: '', mother_occupation: '', father_vangusam: '', mother_vangusam: '',
      brothers_count: '', brothers_married: '', sisters_count: '', sisters_married: '',
      family_status: '', family_type: '', family_values: '',
      soveran_details: '', about_family: '', property_description: '',
    },

    async init() {
      await this.loadFamilyData();
    },

    async loadFamilyData() {
      try {
        const profileId = {{ $profile['id'] ?? 'null' }};
        if (!profileId) return;
        const res = await fetch('/profile/family/load?profile_id=' + profileId, {
          headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        });
        const data = await res.json();
        if (data.success && data.data) {
          const d = data.data;
          this.familyForm.surname = d.surname || '';
          this.familyForm.soveran_name = d.soveran_name || '';
          this.familyForm.father_name = d.father_name || '';
          this.familyForm.father_occupation = d.father_occupation || '';
          this.familyForm.mother_name = d.mother_name || '';
          this.familyForm.mother_occupation = d.mother_occupation || '';
          this.familyForm.father_vangusam = d.father_vangusam || '';
          this.familyForm.mother_vangusam = d.mother_vangusam || '';
          this.familyForm.brothers_count = d.brothers_count ?? '';
          this.familyForm.brothers_married = d.brothers_married ?? '';
          this.familyForm.sisters_count = d.sisters_count ?? '';
          this.familyForm.sisters_married = d.sisters_married ?? '';
          this.familyForm.family_status = d.family_status || '';
          this.familyForm.family_type = d.family_type || '';
          this.familyForm.family_values = d.family_values || '';
          this.familyForm.soveran_details = d.soveran_details ?? '';
          this.familyForm.about_family = d.about_family || '';
          this.familyForm.property_description = d.property_description || '';
        }
      } catch(e) {}
    },

    async saveFamily() {
      this.familySuccess = '';
      this.familyError = '';
      this.familyLoading = true;
      try {
        const res = await fetch('/profile/family', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          },
          body: JSON.stringify(this.familyForm),
        });
        const data = await res.json();
        if (data.success) {
          this.familySuccess = data.message;
          window.scrollTo(0, 0);
          setTimeout(() => { window.location.href = '/profile/me'; }, 1000);
        } else {
          this.familyError = data.message;
        }
      } catch(e) {
        this.familyError = 'Something went wrong.';
      }
      this.familyLoading = false;
    },

    partnerLoading: false,
    partnerSuccess: '',
    partnerError: '',
    partnerForm: {
      preferred_age_min:        '{{ $partner_preference["preferred_age_min"] ?? "" }}',
      preferred_age_max:        '{{ $partner_preference["preferred_age_max"] ?? "" }}',
      preferred_height_min:     '{{ $partner_preference["preferred_height_min"] ?? "" }}',
      preferred_height_max:     '{{ $partner_preference["preferred_height_max"] ?? "" }}',
      marital_status:           '{{ $partner_preference["marital_status"] ?? "" }}',
      children_acceptables:     '{{ $partner_preference["children_acceptables"] ?? "" }}',
      religion:                 '{{ $partner_preference["religion"] ?? "" }}',
      caste:                    '{{ $partner_preference["caste"] ?? "" }}',
      education:                '{{ $partner_preference["education"] ?? "" }}',
      occupation:               '{{ $partner_preference["occupation"] ?? "" }}',
      profession:               '{{ $partner_preference["profession"] ?? "" }}',
      location:                 '{{ $partner_preference["location"] ?? "" }}',
      family_type:              '{{ $partner_preference["family_type"] ?? "" }}',
      horoscope_required:       '{{ $partner_preference["horoscope_required"] ?? "" }}',
      horoscope_natchathiram:   '{{ $partner_preference["horoscope_natchathiram"] ?? "" }}',
      horoscope_rasi:           '{{ $partner_preference["horoscope_rasi"] ?? "" }}',
      dosham:                   '{{ $partner_preference["dosham"] ?? "" }}',
      type_of_dosham:           '{{ $partner_preference["type_of_dosham"] ?? "" }}',
      drinking:                 '{{ $partner_preference["drinking"] ?? "" }}',
      smoking:                  '{{ $partner_preference["smoking"] ?? "" }}',
      body_type:                '{{ $partner_preference["body_type"] ?? "" }}',
      physical_status:          '{{ $partner_preference["physical_status"] ?? "" }}',
      expectations:             @json($partner_preference["expectations"] ?? ""),
    },

    async loadPartnerData() {
      try {
        const profileId = {{ $profile['id'] ?? 'null' }};
        if (!profileId) return;
        const res = await fetch('/profile/partner/load?profile_id=' + profileId, {
          headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        });
        const data = await res.json();
        if (data.success && data.data) {
          const d = data.data;
          Object.keys(this.partnerForm).forEach(k => {
            if (d[k] !== undefined && d[k] !== null) this.partnerForm[k] = d[k];
          });
        }
      } catch(e) {}
    },

    async savePartner() {
      this.partnerSuccess = '';
      this.partnerError = '';
      this.partnerLoading = true;
      if (this.partnerForm.preferred_age_min && this.partnerForm.preferred_age_max && parseInt(this.partnerForm.preferred_age_min) > parseInt(this.partnerForm.preferred_age_max)) {
        this.partnerError = 'Minimum age cannot be greater than maximum age.';
        this.partnerLoading = false;
        return;
      }
      if (this.partnerForm.preferred_height_min && this.partnerForm.preferred_height_max && parseInt(this.partnerForm.preferred_height_min) > parseInt(this.partnerForm.preferred_height_max)) {
        this.partnerError = 'Minimum height cannot be greater than maximum height.';
        this.partnerLoading = false;
        return;
      }
      try {
        const res = await fetch('/profile/partner', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          },
          body: JSON.stringify(this.partnerForm),
        });
        const data = await res.json();
        if (data.success) {
          this.partnerSuccess = data.message;
          window.scrollTo(0, 0);
          setTimeout(() => { window.location.href = '/profile/me'; }, 1000);
        } else {
          this.partnerError = data.message;
        }
      } catch(e) {
        this.partnerError = 'Something went wrong.';
      }
      this.partnerLoading = false;
    },

    async changePassword() {
      this.pwSuccess = '';
      this.pwError = '';
      this.pwLoading = true;
      try {
        const res = await fetch('/profile/change-password', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          },
          body: JSON.stringify(this.pwForm),
        });
        const data = await res.json();
        if (data.success) {
          this.pwSuccess = data.message;
          this.pwForm = { current_password: '', new_password: '', new_password_confirmation: '' };
        } else {
          this.pwError = data.message;
        }
      } catch (e) {
        this.pwError = peI18n.somethingWrong;
      }
      this.pwLoading = false;
    }
  }
}

async function saveHoroscopeBoxes(btn) {
  const msg = document.getElementById('hbox-msg');
  msg.textContent = peI18n.saving;
  msg.className = 'text-sm text-gray-500';
  btn.disabled = true;
  const csrf = document.querySelector('meta[name="csrf-token"]').content;
  const profileId = {{ $profile['id'] ?? 'null' }};
  if (!profileId) {
    msg.textContent = peI18n.profileIdNotFound;
    msg.className = 'text-sm text-red-600';
    btn.disabled = false;
    return;
  }
  const allItems = [];
  document.querySelectorAll('select[data-type]').forEach(sel => {
    const bn = parseInt(sel.dataset.box);
    const slot = parseInt(sel.dataset.slot);
    const type = sel.dataset.type;
    const val = sel.value.trim();
    allItems.push({ profile_id: profileId, box_number: bn, item_number: slot, type: type, value: val });
  });
  const res = await fetch('/horoscope/save-batch', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
    body: JSON.stringify({ profile_id: profileId, items: allItems })
  });
  const data = await res.json();
  btn.disabled = false;
  if (data.success) {
    msg.textContent = peI18n.chartsSaved;
    msg.className = 'text-sm text-green-600';
  } else {
    msg.textContent = peI18n.chartsSaveFailed;
    msg.className = 'text-sm text-red-600';
  }
}

function previewPhoto(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => document.getElementById('photoPreview').src = e.target.result;
    reader.readAsDataURL(input.files[0]);
  }
}

async function uploadPhoto() {
  const input = document.getElementById('photoInput');
  const status = document.getElementById('photoStatus');
  if (!input.files || !input.files[0]) {
    status.textContent = peI18n.selectPhotoFirst;
    status.className = 'text-xs mt-1 text-red-500';
    return;
  }
  status.textContent = peI18n.uploading;
  status.className = 'text-xs mt-1 text-gray-500';
  const formData = new FormData();
  formData.append('profile_id', '{{ $profile["id"] ?? "" }}');
  formData.append('photo_url[]', input.files[0]);
  formData.append('is_primary', '1');
  try {
    const res = await fetch('/photo/upload', {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
      body: formData,
    });
    const data = await res.json();
    if (data.success) {
      status.textContent = peI18n.photoUploaded;
      status.className = 'text-xs mt-1 text-green-600';
    } else {
      status.textContent = data.message ?? peI18n.uploadFailed;
      status.className = 'text-xs mt-1 text-red-500';
    }
  } catch (e) {
    status.textContent = peI18n.uploadError;
    status.className = 'text-xs mt-1 text-red-500';
  }
}

</script>
@endsection

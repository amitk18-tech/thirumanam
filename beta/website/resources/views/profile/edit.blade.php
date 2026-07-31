@extends('layouts.app')

@section('title', 'Edit Profile — Thirumanam')

@section('content')
<div class="min-h-screen bg-gray-50" x-data="profileEdit()">

  <div class="bg-red-900 text-white py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <h1 class="text-2xl font-bold">Edit Profile</h1>
      <p class="text-red-200 text-sm mt-1">Keep your profile updated to get better matches</p>
    </div>
  </div>

  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div x-show="success" x-cloak class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm" x-text="success"></div>
    <div x-show="error" x-cloak class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-600 text-sm" x-text="error"></div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

      <div class="flex overflow-x-auto border-b border-gray-100">
        @foreach(['basic' => 'Basic', 'horoscope' => 'Horoscope', 'physical' => 'Physical', 'career' => 'Career', 'contact' => 'Contact', 'security' => 'Security'] as $key => $label)
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
              <label class="label">Profile Photo</label>
              <input type="file" id="photoInput" accept="image/*" class="text-sm text-gray-600"
                onchange="previewPhoto(this)">
              <button type="button" onclick="uploadPhoto()"
                class="mt-2 px-4 py-1.5 bg-[#8B1A1A] text-white text-sm rounded hover:bg-[#6e1414]">
                Upload Photo
              </button>
              <p id="photoStatus" class="text-xs mt-1 text-gray-500"></p>
            </div>
          </div>
          
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="label">Gender</label>
              <select x-model="form.gender" class="input">
                <option value="">Select</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
            </div>
            <div>
              <label class="label">Date of Birth</label>
              <input type="date" x-model="form.dob" class="input">
            </div>
            <div>
              <label class="label">Marital Status</label>
              <select x-model="form.marital_status" class="input">
                <option value="">Select</option>
                <option value="never_married">Never Married</option>
                <option value="divorced">Divorced</option>
                <option value="widowed">Widowed</option>
                <option value="separated">Separated</option>
              </select>
            </div>
            <div x-show="form.marital_status !== 'never_married'">
              <label class="label">Number of Children</label>
              <input type="number" x-model="form.number_of_children" class="input" min="0" placeholder="0">
            </div>
            <div x-show="form.marital_status !== 'never_married'">
              <label class="label">Children Living Place</label>
              <select x-model="form.children_living_place" class="input">
                <option value="">Select</option>
                <option value="living_with_me">Living with me</option>
                <option value="not_living_with_me">Not living with me</option>
              </select>
            </div>
          </div>
          <div>
            <label class="label">Introduction</label>
            <textarea x-model="form.introduction" rows="4" class="input" placeholder="Write a short introduction about yourself..."></textarea>
          </div>
        </div>

        {{-- Horoscope --}}
        <div x-show="tab === 'horoscope'" class="space-y-4">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="label">Star (Natchathiram)</label>
              <select x-model="form.star" class="input">
                <option value="">Select</option>
                @foreach(['Ashwini','Bharani','Krittika','Rohini','Mrigashira','Ardra','Punarvasu','Pushya','Ashlesha','Magha','Purva Phalguni','Uttara Phalguni','Hasta','Chitra','Swati','Vishakha','Anuradha','Jyeshtha','Mula','Purva Ashadha','Uttara Ashadha','Shravana','Dhanishtha','Shatabhisha','Purva Bhadrapada','Uttara Bhadrapada','Revati'] as $s)
                  <option value="{{ $s }}">{{ $s }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label class="label">Rasi</label>
              <select x-model="form.rasi" class="input">
                <option value="">Select</option>
                @foreach(['Mesha','Rishabha','Mithuna','Kataka','Simha','Kanya','Tula','Vrischika','Dhanus','Makara','Kumbha','Meena'] as $r)
                  <option value="{{ $r }}">{{ $r }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label class="label">Paksha</label>
              <select x-model="form.paksha" class="input">
                <option value="">Select</option>
                <option value="shukla">Shukla</option>
                <option value="krishna">Krishna</option>
              </select>
            </div>
            <div>
              <label class="label">Tithi</label>
              <input type="text" x-model="form.tithi" class="input" placeholder="e.g. Panchami">
            </div>
            <div>
              <label class="label">Ganam</label>
              <select x-model="form.ganam" class="input">
                <option value="">Select</option>
                <option value="dev">Dev</option>
                <option value="manush">Manush</option>
                <option value="rakshas">Rakshas</option>
              </select>
            </div>
            <div>
              <label class="label">Nadi</label>
              <select x-model="form.nadi" class="input">
                <option value="">Select</option>
                <option value="adi">Adi</option>
                <option value="madhya">Madhya</option>
                <option value="antya">Antya</option>
              </select>
            </div>
            <div>
              <label class="label">Dosham</label>
              <select x-model="form.dosham" class="input">
                <option value="">Select</option>
                <option value="no">No</option>
                <option value="yes">Yes</option>
                <option value="partial">Partial</option>
              </select>
            </div>
            <div>
              <label class="label">Type of Dosham</label>
              <input type="text" x-model="form.type_of_dosham" class="input" placeholder="e.g. 12-mars">
            </div>
            <div>
              <label class="label">Horoscope Matching</label>
              <select x-model="form.horoscope_matching" class="input">
                <option value="">Select</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
              </select>
            </div>
            <div>
              <label class="label">Birth Time</label>
              <input type="time" x-model="form.birth_time" class="input">
            </div>
            <div>
              <label class="label">Birth City</label>
              <input type="text" x-model="form.birth_city" class="input" placeholder="e.g. Chennai">
            </div>
            <div>
              <label class="label">Birth Place</label>
              <input type="text" x-model="form.birth_place" class="input" placeholder="e.g. Tamil Nadu">
            </div>
            <div>
              <label class="label">Birth Country</label>
              <input type="text" x-model="form.birth_country" class="input" placeholder="e.g. India">
            </div>
            <div>
              <label class="label">Birth State</label>
              <input type="text" x-model="form.birth_state" class="input" placeholder="e.g. Tamil Nadu">
            </div>
            <div>
              <label class="label">Lakknam</label>
              <input type="text" x-model="form.lakknam" class="input" placeholder="e.g. Taurus">
            </div>
            <div>
              <label class="label">Directional Balance</label>
              <input type="text" x-model="form.directional_balance" class="input" placeholder="e.g. East">
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
            $chartTypes = ['ZODIAC' => 'Rasi Chart', 'FEATURE' => 'Feature Chart'];
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
                        <td class="border-2 border-green-300 bg-yellow-50 text-center font-semibold text-gray-500 align-middle" colspan="2" rowspan="2" style="height:5.5em">{{ $chartType }}</td>
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
            <button type="button" onclick="saveHoroscopeBoxes(this)" class="px-4 py-2 bg-[#8B1A1A] text-white text-sm rounded-lg hover:bg-red-800">Save Charts</button>
            <span id="hbox-msg" class="text-sm"></span>
          </div>
        </div>

        {{-- Physical --}}
        <div x-show="tab === 'physical'" class="space-y-4">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="label">Height (cm)</label>
              <input type="number" x-model="form.height" class="input" placeholder="e.g. 170">
            </div>
            <div>
              <label class="label">Weight (kg)</label>
              <input type="number" x-model="form.weight" class="input" placeholder="e.g. 65">
            </div>
            <div>
              <label class="label">Complexion</label>
              <select x-model="form.complexion" class="input">
                <option value="">Select</option>
                <option value="fair">Fair</option>
                <option value="wheatish">Wheatish</option>
                <option value="dark">Dark</option>
              </select>
            </div>
            <div>
              <label class="label">Body Type</label>
              <select x-model="form.body_type" class="input">
                <option value="">Select</option>
                <option value="slim">Slim</option>
                <option value="athletic">Athletic</option>
                <option value="average">Average</option>
                <option value="heavy">Heavy</option>
              </select>
            </div>
            <div>
              <label class="label">Blood Group</label>
              <select x-model="form.blood_group" class="input">
                <option value="">Select</option>
                @foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $bg)
                  <option value="{{ $bg }}">{{ $bg }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label class="label">Physical Status</label>
              <select x-model="form.physical_status" class="input">
                <option value="">Select</option>
                <option value="normal">Normal</option>
                <option value="differently_abled">Differently Abled</option>
              </select>
            </div>
            <div>
              <label class="label">Eye Color</label>
              <input type="text" x-model="form.eye_color" class="input" placeholder="e.g. Black">
            </div>
            <div>
              <label class="label">Hair Color</label>
              <input type="text" x-model="form.hair_color" class="input" placeholder="e.g. Black">
            </div>
          </div>
        </div>

        {{-- Career --}}
        <div x-show="tab === 'career'" class="space-y-4">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="label">Education</label>
              <input type="text" x-model="form.education" class="input" placeholder="e.g. B.Tech">
            </div>
            <div>
              <label class="label">Study Details</label>
              <input type="text" x-model="form.study_details" class="input" placeholder="e.g. Computer Science">
            </div>
            <div>
              <label class="label">Occupation</label>
              <input type="text" x-model="form.occupation" class="input" placeholder="e.g. Software Engineer">
            </div>
            <div>
              <label class="label">Work Location</label>
              <input type="text" x-model="form.work_location" class="input" placeholder="e.g. Bangalore">
            </div>
            <div>
              <label class="label">Income Level</label>
              <select x-model="form.income" class="input">
                <option value="">Select</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
              </select>
            </div>
            <div>
              <label class="label">Income Amount (monthly)</label>
              <input type="number" x-model="form.income_amount" class="input" placeholder="e.g. 50000">
            </div>
            <div>
              <label class="label">Earnings Type</label>
              <select x-model="form.earnings" class="input">
                <option value="">Select</option>
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
              </select>
            </div>
          </div>
          <div>
            <label class="label">Career Profile</label>
            <textarea x-model="form.career_profile" rows="3" class="input" placeholder="Brief description of your career..."></textarea>
          </div>
        </div>

        {{-- Contact --}}
        <div x-show="tab === 'contact'" class="space-y-4">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="label">City</label>
              <input type="text" x-model="form.city" class="input" placeholder="e.g. Chennai">
            </div>
            <div>
              <label class="label">Current City</label>
              <input type="text" x-model="form.current_city" class="input" placeholder="e.g. Bangalore">
            </div>
            <div>
              <label class="label">State</label>
              <input type="text" x-model="form.state" class="input" placeholder="e.g. Tamil Nadu">
            </div>
            <div>
              <label class="label">Country</label>
              <input type="text" x-model="form.country" class="input" placeholder="e.g. India">
            </div>
            <div>
              <label class="label">Native Place</label>
              <input type="text" x-model="form.native_place" class="input" placeholder="e.g. Madurai">
            </div>
            <div>
              <label class="label">Postal Code</label>
              <input type="text" x-model="form.postal_code" class="input" placeholder="e.g. 600001">
            </div>
            <div>
              <label class="label">Mobile</label>
              <input type="text" value="{{ $user['profile']['user']['phone'] ?? $profile['mobile'] ?? '' }}" class="input bg-gray-100 cursor-not-allowed" readonly disabled>
            </div>
            <div>
              <label class="label">Alternate Number</label>
              <input type="text" x-model="form.alternate_number" class="input">
            </div>
            <div>
              <label class="label">Landline</label>
              <input type="text" x-model="form.landline" class="input" placeholder="e.g. 044-12345678">
            </div>
          </div>
          <div>
            <label class="label">Address</label>
            <textarea x-model="form.address" rows="3" class="input" placeholder="Full address..."></textarea>
          </div>
        </div>

        {{-- Security --}}
        <div x-show="tab === 'security'" class="space-y-4">
          <p class="text-sm text-gray-500">Change your login password below.</p>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
            <div>
              <label class="label">Current Password</label>
              <div class="relative">
                <input :type="showCurrent ? 'text' : 'password'" x-model="pwForm.current_password" class="input pr-10" placeholder="Enter current password" autocomplete="new-password">
                <button type="button" @click="showCurrent = !showCurrent" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                  <i :class="showCurrent ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                </button>
              </div>
            </div>
            <div>
              <label class="label">New Password</label>
              <div class="relative">
                <input :type="showNew ? 'text' : 'password'" x-model="pwForm.new_password" class="input pr-10" placeholder="Enter new password">
                <button type="button" @click="showNew = !showNew" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                  <i :class="showNew ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                </button>
              </div>
            </div>
            <div>
              <label class="label">Confirm New Password</label>
              <div class="relative">
                <input :type="showConfirm ? 'text' : 'password'" x-model="pwForm.new_password_confirmation" class="input pr-10" placeholder="Confirm new password">
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
              <span x-show="!pwLoading">Change Password</span>
              <span x-show="pwLoading">Saving...</span>
            </button>
          </div>
        </div>

        <div x-show="tab !== 'security'" class="mt-6 flex justify-end">
          <button type="submit" :disabled="loading"
                  class="bg-red-800 hover:bg-red-900 text-white px-8 py-3 rounded-lg font-semibold transition disabled:opacity-50">
            <span x-show="!loading">Save Changes</span>
            <span x-show="loading">Saving...</span>
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
          this.success = data.message ?? 'Profile updated successfully!';
          window.scrollTo(0, 0);
          setTimeout(() => { window.location.href = '/profile/me'; }, 1000);
        } else {
          this.error = data.message ?? 'Failed to update profile.';
        }
      } catch (e) {
        this.error = 'Something went wrong. Please try again.';
      }
      this.loading = false;
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
        this.pwError = 'Something went wrong. Please try again.';
      }
      this.pwLoading = false;
    }
  }
}

async function saveHoroscopeBoxes(btn) {
  const msg = document.getElementById('hbox-msg');
  msg.textContent = 'Saving...';
  msg.className = 'text-sm text-gray-500';
  btn.disabled = true;
  const csrf = document.querySelector('meta[name="csrf-token"]').content;
  const profileId = {{ $profile['id'] ?? 'null' }};
  if (!profileId) {
    msg.textContent = 'Profile ID not found.';
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
    msg.textContent = 'Charts saved!';
    msg.className = 'text-sm text-green-600';
  } else {
    msg.textContent = 'Failed to save charts. Please try again.';
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
    status.textContent = 'Please select a photo first.';
    status.className = 'text-xs mt-1 text-red-500';
    return;
  }
  status.textContent = 'Uploading...';
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
      status.textContent = 'Photo uploaded successfully!';
      status.className = 'text-xs mt-1 text-green-600';
    } else {
      status.textContent = data.message ?? 'Upload failed.';
      status.className = 'text-xs mt-1 text-red-500';
    }
  } catch (e) {
    status.textContent = 'Upload error. Please try again.';
    status.className = 'text-xs mt-1 text-red-500';
  }
}

</script>
@endsection

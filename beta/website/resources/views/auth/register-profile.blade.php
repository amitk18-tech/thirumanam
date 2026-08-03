@extends('layouts.app')

@section('title', __('ui.rp_title') . ' — Thirumanam')

@section('content')
<div class="min-h-screen bg-rose-50 flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-lg">

        <div class="text-center mb-8">
            <a href="/" class="text-3xl font-bold text-primary">திருமணம்</a>
            <p class="text-gray-500 mt-1">{{ __('ui.rp_complete_profile') }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8" x-data="profileForm()">

            <h2 class="text-xl font-bold text-gray-800 mb-1">{{ __('ui.rp_profile_details') }}</h2>
            <p class="text-gray-500 text-sm mb-6">{{ __('ui.rp_subtitle') }}</p>

            <div x-show="error" x-cloak class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-600 text-sm" x-text="error"></div>

            {{-- Show selected gender as read-only --}}
            @php $sessionUser = session('user'); $sessionGender = session('register_gender') ?? $sessionUser['profile']['gender'] ?? ''; @endphp
            @if($sessionGender)
            <div class="mb-4 p-3 bg-red-50 border border-red-100 rounded-lg flex items-center gap-3">
                <span class="text-2xl">{{ $sessionGender === 'male' ? '👨' : '👩' }}</span>
                <div>
                    <p class="text-sm font-semibold text-primary">{{ __('ui.rp_registering_as') }} {{ $sessionGender === 'male' ? __('ui.reg_groom') : __('ui.reg_bride') }}</p>
                    <p class="text-xs text-gray-500">{{ __('ui.rp_selected_previous_step') }}</p>
                </div>
            </div>
            @endif

            <div class="space-y-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.ms_label_dob') }} <span class="text-red-500">*</span></label>
                    <input type="date" x-model="dob"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.ms_label_marital_status') }} <span class="text-red-500">*</span></label>
                    <select x-model="marital_status"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">{{ __('ui.rp_select_status') }}</option>
                        <option value="never_married">{{ __('ui.never_married') }}</option>
                        <option value="divorced">{{ __('ui.divorced') }}</option>
                        <option value="widowed">{{ __('ui.widowed') }}</option>
                        <option value="separated">{{ __('ui.separated') }}</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.rp_fathers_name') }}</label>
                        <input type="text" x-model="father_name" placeholder="{{ __('ui.rp_ph_fathers_name') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.rp_mothers_name') }}</label>
                        <input type="text" x-model="mother_name" placeholder="{{ __('ui.rp_ph_mothers_name') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.ms_label_education') }}</label>
                    <input type="text" x-model="education" placeholder="{{ __('ui.rp_ph_education') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.ms_label_occupation') }}</label>
                    <input type="text" x-model="occupation" placeholder="{{ __('ui.rp_ph_occupation') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.ms_label_city') }}</label>
                    <input type="text" x-model="city" placeholder="{{ __('ui.rp_ph_city') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary">
                </div>


            </div>

            <button @click="saveProfile" :disabled="loading"
                class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-red-900 transition disabled:opacity-50 mt-6">
                <span x-show="!loading">{{ __('ui.rp_complete_and_dashboard') }}</span>
                <span x-show="loading">{{ __('ui.pe_saving') }}</span>
            </button>

        </div>
    </div>
</div>

<script>
const rpI18n = {
    errDobRequired:            @json(__('ui.rp_err_dob_required')),
    errMaritalStatusRequired:  @json(__('ui.rp_err_marital_status_required')),
    errSaveFailed:             @json(__('ui.rp_err_save_failed')),
    errServer:                 @json(__('ui.rp_err_server')),
    errCheckConsole:           @json(__('ui.rp_err_check_console')),
    errPrefix:                 @json(__('ui.reg_err_prefix')),
};

function profileForm() {
    return {
        gender: '{{ $sessionGender }}',
        dob: '',
        marital_status: '',
        father_name: '',
        mother_name: '',
        education: '',
        occupation: '',
        city: '',
        
        loading: false,
        error: '',

        async saveProfile() {
            this.error = '';
            if (!this.dob) { this.error = rpI18n.errDobRequired; return; }
            if (!this.marital_status) { this.error = rpI18n.errMaritalStatusRequired; return; }

            this.loading = true;
            try {
                const res = await fetch('/register/profile', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        gender: this.gender,
                        dob: this.dob,
                        marital_status: this.marital_status,
                        father_name: this.father_name,
                        mother_name: this.mother_name,
                        education: this.education,
                        occupation: this.occupation,
                        city: this.city,
                        
                    }),
                });
                const text = await res.text();
                console.log('Raw response:', text);
                let data;
                try { data = JSON.parse(text); } catch(je) {
                    this.error = rpI18n.errServer + ' (HTTP ' + res.status + ').';
                    console.error('Non-JSON response:', text.substring(0, 500));
                    this.loading = false;
                    return;
                }
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    this.error = data.message || rpI18n.errSaveFailed;
                }
            } catch (e) {
                this.error = rpI18n.errPrefix + ': ' + e.message + ' — ' + rpI18n.errCheckConsole;
                console.error('Profile save error:', e);
            }
            this.loading = false;
        }
    }
}
</script>
@endsection

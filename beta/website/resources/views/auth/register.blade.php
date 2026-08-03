@extends('layouts.app')

@section('title', __('ui.reg_title') . ' — Thirumanam')

@section('content')
<div class="min-h-screen bg-rose-50 flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="/" class="text-3xl font-bold text-primary">திருமணம்</a>
            <p class="text-gray-500 mt-1">{{ __('ui.reg_create_profile') }}</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-lg p-8" x-data="registerForm()">

            {{-- Step Indicator --}}
            <div class="flex items-center justify-between mb-8">
                <template x-for="(label, i) in steps" :key="i">
                    <div class="flex items-center">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors"
                                :class="currentStep > i+1 ? 'bg-green-500 text-white' : currentStep === i+1 ? 'bg-primary text-white' : 'bg-gray-200 text-gray-500'">
                                <span x-show="currentStep <= i+1" x-text="i+1"></span>
                                <span x-show="currentStep > i+1">✓</span>
                            </div>
                            <span class="text-xs mt-1 text-gray-500" x-text="label"></span>
                        </div>
                        <div x-show="i < steps.length - 1" class="w-12 h-0.5 mx-1 mb-4"
                            :class="currentStep > i+1 ? 'bg-green-500' : 'bg-gray-200'"></div>
                    </div>
                </template>
            </div>

            {{-- Error Message --}}
            <div x-show="error" x-cloak class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-600 text-sm" x-text="error"></div>

            {{-- Step 1: Mobile Number --}}
            <div x-show="currentStep === 1">
                <h2 class="text-xl font-bold text-gray-800 mb-1">{{ __('ui.reg_enter_mobile') }}</h2>
                <p class="text-gray-500 text-sm mb-6">{{ __('ui.reg_otp_notice') }}</p>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.login_mobile_number') }}</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 bg-gray-100 border border-r-0 border-gray-300 rounded-l-lg text-gray-500 text-sm">+91</span>
                        <input type="tel" x-model="mobile" maxlength="10" placeholder="{{ __('ui.reg_10_digit_number') }}"
                            class="flex-1 border border-gray-300 rounded-r-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                            @keyup.enter="sendOtp">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('ui.reg_registering_as') }}</label>
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" @click="gender = 'male'"
                            :class="gender === 'male' ? 'border-primary bg-red-50 text-primary' : 'border-gray-300 text-gray-600'"
                            class="border-2 rounded-lg py-3 font-medium transition">
                            👨 {{ __('ui.reg_groom') }}
                        </button>
                        <button type="button" @click="gender = 'female'"
                            :class="gender === 'female' ? 'border-primary bg-red-50 text-primary' : 'border-gray-300 text-gray-600'"
                            class="border-2 rounded-lg py-3 font-medium transition">
                            👩 {{ __('ui.reg_bride') }}
                        </button>
                    </div>
                </div>
                <button @click="sendOtp" :disabled="loading"
                    class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-red-900 transition disabled:opacity-50">
                    <span x-show="!loading">{{ __('ui.reg_send_otp') }}</span>
                    <span x-show="loading">{{ __('ui.reg_sending') }}</span>
                </button>
                <p class="text-center text-sm text-gray-500 mt-4">{{ __('ui.reg_already_registered') }} <a href="/login" class="text-primary font-medium">{{ __('ui.login') }}</a></p>
            </div>

            {{-- Step 2: OTP Verification --}}
            <div x-show="currentStep === 2">
                <h2 class="text-xl font-bold text-gray-800 mb-1">{{ __('ui.reg_verify_otp') }}</h2>
                <p class="text-gray-500 text-sm mb-6">{{ __('ui.reg_otp_sent_to') }} +91 <span x-text="mobile"></span></p>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.reg_otp_label') }}</label>
                    <input type="tel" x-model="otp" maxlength="6" placeholder="{{ __('ui.reg_6_digit_otp') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent tracking-widest text-center text-xl"
                        @keyup.enter="verifyOtp">
                </div>
                <button @click="verifyOtp" :disabled="loading"
                    class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-red-900 transition disabled:opacity-50">
                    <span x-show="!loading">{{ __('ui.reg_verify_otp') }}</span>
                    <span x-show="loading">{{ __('ui.reg_verifying') }}</span>
                </button>
                <p class="text-center text-sm text-gray-500 mt-4">
                    {{ __('ui.reg_didnt_receive') }}
                    <button @click="resendOtp" :disabled="resendCooldown > 0" class="text-primary font-medium disabled:text-gray-400">
                        <span x-show="resendCooldown === 0">{{ __('ui.reg_resend_otp') }}</span>
                        <span x-show="resendCooldown > 0">{{ __('ui.reg_resend_in') }} <span x-text="resendCooldown"></span>s</span>
                    </button>
                </p>
                <p class="text-center text-sm text-gray-500 mt-2"><button @click="currentStep = 1; error = ''" class="text-gray-400 hover:text-gray-600">← {{ __('ui.reg_change_number') }}</button></p>
            </div>

            {{-- Step 3: Account Details --}}
            <div x-show="currentStep === 3">
                <h2 class="text-xl font-bold text-gray-800 mb-1">{{ __('ui.reg_create_account') }}</h2>
                <p class="text-gray-500 text-sm mb-6">{{ __('ui.reg_fill_basic_details') }}</p>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.reg_full_name') }}</label>
                        <input type="text" x-model="name" placeholder="{{ __('ui.reg_enter_full_name') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.reg_email_address') }}</label>
                        <input type="email" x-model="email" placeholder="{{ __('ui.reg_enter_email') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.login_password') }}</label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" x-model="password" placeholder="{{ __('ui.reg_min_6_chars') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-primary">
                            <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-3.5 text-gray-400">
                                <i :class="showPassword ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                </div>

                <button @click="completeSetup" :disabled="loading"
                    class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-red-900 transition disabled:opacity-50 mt-6">
                    <span x-show="!loading">{{ __('ui.reg_create_account') }}</span>
                    <span x-show="loading">{{ __('ui.reg_creating_account') }}</span>
                </button>
            </div>

        </div>
    </div>
</div>

<script>
const regI18n = {
    stepMobile:            @json(__('ui.reg_step_mobile')),
    stepVerify:             @json(__('ui.reg_step_verify')),
    stepDetails:            @json(__('ui.reg_step_details')),
    errInvalidMobile:       @json(__('ui.reg_err_invalid_mobile')),
    errSelectGender:        @json(__('ui.reg_err_select_gender')),
    errBothGendersExist:    @json(__('ui.reg_err_both_genders_exist')),
    errSendOtpFailed:       @json(__('ui.reg_err_send_otp_failed')),
    errInvalidOtp6:         @json(__('ui.reg_err_invalid_otp6')),
    errInvalidOtp:          @json(__('ui.reg_err_invalid_otp')),
    errNameRequired:        @json(__('ui.reg_err_name_required')),
    errEmailRequired:       @json(__('ui.reg_err_email_required')),
    errPasswordMin:         @json(__('ui.reg_err_password_min')),
    errRegistrationFailed:  @json(__('ui.reg_err_registration_failed')),
    errPrefix:              @json(__('ui.reg_err_prefix')),
};

function registerForm() {
    return {
        currentStep: 1,
        steps: [regI18n.stepMobile, regI18n.stepVerify, regI18n.stepDetails],
        mobile: '',
        otp: '',
        setupToken: '',
        name: '',
        email: '',
        password: '',
        gender: '',
        showPassword: false,
        loading: false,
        error: '',
        resendCooldown: 0,

        async sendOtp() {
            this.error = '';
            if (this.mobile.length !== 10) {
                this.error = regI18n.errInvalidMobile;
                return;
            }
            if (!this.gender) {
                this.error = regI18n.errSelectGender;
                return;
            }
            this.loading = true;
            try {
                const res = await fetch('/register/send-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ mobile: this.mobile, gender: this.gender }),
                });
                const data = await res.json();
                if (data.success) {
                    // Check if both genders already exist
                    if (data.existing_genders && data.existing_genders.includes('male') && data.existing_genders.includes('female')) {
                        this.error = regI18n.errBothGendersExist;
                    } else {
                        this.currentStep = 2;
                        this.startResendTimer();
                    }
                } else {
                    this.error = data.message || regI18n.errSendOtpFailed;
                }
            } catch (e) {
                this.error = regI18n.errPrefix + ': ' + e.message;
            }
            this.loading = false;
        },

        async verifyOtp() {
            this.error = '';
            if (this.otp.length !== 6) {
                this.error = regI18n.errInvalidOtp6;
                return;
            }
            this.loading = true;
            try {
                const res = await fetch('/register/verify-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ mobile: this.mobile, otp: this.otp }),
                });
                const data = await res.json();
                if (data.success) {
                    this.setupToken = data.setup_token;
                    this.currentStep = 3;
                } else {
                    this.error = data.message || regI18n.errInvalidOtp;
                }
            } catch (e) {
                this.error = regI18n.errPrefix + ': ' + e.message;
            }
            this.loading = false;
        },

        async completeSetup() {
            this.error = '';
            if (!this.name) { this.error = regI18n.errNameRequired; return; }
            if (!this.email) { this.error = regI18n.errEmailRequired; return; }
            if (this.password.length < 6) { this.error = regI18n.errPasswordMin; return; }
            this.loading = true;
            try {
                const res = await fetch('/register/complete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        setup_token: this.setupToken,
                        mobile: this.mobile,
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        gender: this.gender,
                    }),
                });
                const data = await res.json();
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    this.error = data.message || regI18n.errRegistrationFailed;
                }
            } catch (e) {
                this.error = regI18n.errPrefix + ': ' + e.message;
            }
            this.loading = false;
        },

        async resendOtp() {
            this.otp = '';
            await this.sendOtp();
        },

        startResendTimer() {
            this.resendCooldown = 60;
            const timer = setInterval(() => {
                this.resendCooldown--;
                if (this.resendCooldown <= 0) clearInterval(timer);
            }, 1000);
        },
    }
}
</script>
@endsection

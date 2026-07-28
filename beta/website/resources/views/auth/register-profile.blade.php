@extends('layouts.app')

@section('title', 'Complete Your Profile — Thirumanam')

@section('content')
<div class="min-h-screen bg-rose-50 flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-lg">

        <div class="text-center mb-8">
            <a href="/" class="text-3xl font-bold text-primary">திருமணம்</a>
            <p class="text-gray-500 mt-1">Complete your profile</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8" x-data="profileForm()">

            <h2 class="text-xl font-bold text-gray-800 mb-1">Profile Details</h2>
            <p class="text-gray-500 text-sm mb-6">This helps us find the right matches for you.</p>

            <div x-show="error" x-cloak class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-600 text-sm" x-text="error"></div>

            {{-- Show selected gender as read-only --}}
            @php $sessionUser = session('user'); $sessionGender = session('register_gender') ?? $sessionUser['profile']['gender'] ?? ''; @endphp
            @if($sessionGender)
            <div class="mb-4 p-3 bg-red-50 border border-red-100 rounded-lg flex items-center gap-3">
                <span class="text-2xl">{{ $sessionGender === 'male' ? '👨' : '👩' }}</span>
                <div>
                    <p class="text-sm font-semibold text-primary">Registering as {{ $sessionGender === 'male' ? 'Groom' : 'Bride' }}</p>
                    <p class="text-xs text-gray-500">Selected in previous step</p>
                </div>
            </div>
            @endif

            <div class="space-y-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth <span class="text-red-500">*</span></label>
                    <input type="date" x-model="dob"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Marital Status <span class="text-red-500">*</span></label>
                    <select x-model="marital_status"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">Select status</option>
                        <option value="never_married">Never Married</option>
                        <option value="divorced">Divorced</option>
                        <option value="widowed">Widowed</option>
                        <option value="separated">Separated</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Father's Name</label>
                        <input type="text" x-model="father_name" placeholder="Father's full name"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mother's Name</label>
                        <input type="text" x-model="mother_name" placeholder="Mother's full name"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Education</label>
                    <input type="text" x-model="education" placeholder="e.g. B.Tech, MBA"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Occupation</label>
                    <input type="text" x-model="occupation" placeholder="e.g. Software Engineer"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                    <input type="text" x-model="city" placeholder="e.g. Chennai"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary">
                </div>


            </div>

            <button @click="saveProfile" :disabled="loading"
                class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-red-900 transition disabled:opacity-50 mt-6">
                <span x-show="!loading">Complete Profile & Go to Dashboard</span>
                <span x-show="loading">Saving...</span>
            </button>

        </div>
    </div>
</div>

<script>
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
            if (!this.dob) { this.error = 'Please enter your date of birth.'; return; }
            if (!this.marital_status) { this.error = 'Please select marital status.'; return; }

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
                    this.error = 'Server error (HTTP ' + res.status + '). Check console.';
                    console.error('Non-JSON response:', text.substring(0, 500));
                    this.loading = false;
                    return;
                }
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    this.error = data.message || 'Failed to save profile.';
                }
            } catch (e) {
                this.error = 'Error: ' + e.message + ' — Check browser console for details';
                console.error('Profile save error:', e);
            }
            this.loading = false;
        }
    }
}
</script>
@endsection

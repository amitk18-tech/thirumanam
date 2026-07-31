@extends('layouts.app')

@section('title', 'Browse Members — Thirumanam')

@section('content')
<div class="min-h-screen bg-gray-50">

  {{-- Page Header --}}
  <div style="background: linear-gradient(135deg, #7a1010 0%, #a31c1c 60%, #c0392b 100%);" class="text-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-end justify-between">
      <div>
        <h1 class="text-3xl font-bold tracking-tight">Browse Members</h1>
        <p class="text-red-200 mt-1 text-sm">{{ number_format($total) }} profiles found</p>
      </div>
      <div class="hidden sm:flex items-center gap-2 text-red-200 text-sm">
        <i class="fas fa-heart text-pink-400"></i>
        Find your perfect match
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-6">

      {{-- Filter Sidebar --}}
      <aside class="w-full lg:w-64 flex-shrink-0" x-data="{ open: false }">

        <button @click="open = !open"
                class="lg:hidden w-full flex items-center justify-between bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium text-gray-700 mb-4 shadow-sm">
          <span><i class="fas fa-sliders-h mr-2 text-red-700"></i>Filters</span>
          <i class="fas fa-chevron-down transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
        </button>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-4"
             :class="open ? 'block' : 'hidden lg:block'">
          <div class="px-4 py-3 text-white" style="background: linear-gradient(135deg, #7a1010, #a31c1c);">
            <h2 class="text-sm font-semibold uppercase tracking-widest flex items-center gap-2">
              <i class="fas fa-sliders-h text-xs"></i> Filter Profiles
            </h2>
          </div>

          <form method="GET" action="{{ route('members.index') }}" class="p-4 space-y-4">

            <div>
              <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Search</label>
              <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Name or Member ID"
                       class="w-full border border-gray-200 rounded-lg pl-8 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent">
              </div>
            </div>

            <div>
              <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Age Range</label>
              <div class="flex items-center gap-2">
                <input type="number" name="age_from" value="{{ request('age_from') }}"
                       placeholder="Min" min="18" max="70"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                <span class="text-gray-300 font-bold">—</span>
                <input type="number" name="age_to" value="{{ request('age_to') }}"
                       placeholder="Max" min="18" max="70"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
              </div>
            </div>

            <div>
              <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Marital Status</label>
              <select name="marital_status"
                      class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 bg-white">
                <option value="">Any</option>
                <option value="never_married" {{ request('marital_status') === 'never_married' ? 'selected' : '' }}>Never Married</option>
                <option value="divorced"       {{ request('marital_status') === 'divorced'       ? 'selected' : '' }}>Divorced</option>
                <option value="widowed"        {{ request('marital_status') === 'widowed'        ? 'selected' : '' }}>Widowed</option>
                <option value="separated"      {{ request('marital_status') === 'separated'      ? 'selected' : '' }}>Separated</option>
              </select>
            </div>

            <div>
              <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Education</label>
              <select name="education"
                      class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 bg-white">
                <option value="">Any</option>
                <option value="10th"    {{ request('education') === '10th'    ? 'selected' : '' }}>10th</option>
                <option value="12th"    {{ request('education') === '12th'    ? 'selected' : '' }}>12th</option>
                <option value="diploma" {{ request('education') === 'diploma' ? 'selected' : '' }}>Diploma</option>
                <option value="ug"      {{ request('education') === 'ug'      ? 'selected' : '' }}>UG Degree</option>
                <option value="pg"      {{ request('education') === 'pg'      ? 'selected' : '' }}>PG Degree</option>
                <option value="phd"     {{ request('education') === 'phd'     ? 'selected' : '' }}>PhD</option>
              </select>
            </div>

            <div>
              <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">City</label>
              <div class="relative">
                <i class="fas fa-map-marker-alt absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-xs"></i>
                <input type="text" name="city" value="{{ request('city') }}"
                       placeholder="e.g. Chennai"
                       class="w-full border border-gray-200 rounded-lg pl-8 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
              </div>
            </div>

            <div>
              <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Star (Natchathiram)</label>
              <select name="star"
                      class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 bg-white">
                <option value="">Any</option>
                @foreach(['Ashwini','Bharani','Krittika','Rohini','Mrigashira','Ardra','Punarvasu','Pushya','Ashlesha','Magha','Purva Phalguni','Uttara Phalguni','Hasta','Chitra','Swati','Vishakha','Anuradha','Jyeshtha','Mula','Purva Ashadha','Uttara Ashadha','Shravana','Dhanishtha','Shatabhisha','Purva Bhadrapada','Uttara Bhadrapada','Revati'] as $star)
                  <option value="{{ $star }}" {{ request('star') === $star ? 'selected' : '' }}>{{ $star }}</option>
                @endforeach
              </select>
            </div>

            <div>
              <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Rasi</label>
              <select name="rasi"
                      class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 bg-white">
                <option value="">Any</option>
                @foreach(['Mesha','Rishabha','Mithuna','Kataka','Simha','Kanya','Tula','Vrischika','Dhanus','Makara','Kumbha','Meena'] as $rasi)
                  <option value="{{ $rasi }}" {{ request('rasi') === $rasi ? 'selected' : '' }}>{{ $rasi }}</option>
                @endforeach
              </select>
            </div>

            <div class="pt-2 flex gap-2">
              <button type="submit"
                      class="flex-1 text-white text-sm font-semibold py-2.5 rounded-lg transition hover:opacity-90"
                      style="background: linear-gradient(135deg, #7a1010, #a31c1c);">
                <i class="fas fa-search mr-1 text-xs"></i> Apply
              </button>
              <a href="{{ route('members.index') }}"
                 class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium py-2.5 rounded-lg transition">
                Reset
              </a>
            </div>

          </form>
        </div>
      </aside>

      {{-- Results Grid --}}
      <main class="flex-1 min-w-0">

        @if(count($members) === 0)
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
              <i class="fas fa-users text-2xl text-red-300"></i>
            </div>
            <p class="text-gray-600 font-semibold text-lg">No profiles found</p>
            <p class="text-gray-400 text-sm mt-1">Try adjusting your filters</p>
            <a href="{{ route('members.index') }}" class="inline-block mt-4 text-sm text-red-700 hover:underline">Clear all filters</a>
          </div>
        @else

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            @foreach($members as $member)
              @php
                $photo  = $member['profile_photo'] ?? null;
                $gender = strtolower($member['gender'] ?? '');

                if ($photo && !str_contains($photo, 'default_image') && str_starts_with($photo, 'http')) {
                       $photoUrl = $photo;
                } elseif ($photo && !str_contains($photo, 'default_image') && str_starts_with($photo, 'storage/')) {
                          $photoUrl = 'https://api.thirumanam.info/' . $photo;
                } else {
                      $photoUrl = null;
                }

                $defaultAvatar = $gender === 'female'
                    ? 'https://api.thirumanam.info/storage/default_image/default_female.jpg'
                    : 'https://api.thirumanam.info/storage/default_image/default_male.jpg';

                $name       = $member['name']          ?? 'Member';
                $memberId   = $member['member_no']      ?? '—';
                $userId     = $member['id']             ?? null;
                $profileId  = $member['profile_id']     ?? 0;
                $age        = $member['age']            ?? null;
                $city       = $member['city']           ?? null;
                $education  = $member['education']      ?? null;
                $occupation = $member['occupation']     ?? null;
                $marital    = $member['marital_status'] ?? null;
              @endphp

              <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 group flex flex-col">

                {{-- Photo --}}
                <div class="relative overflow-hidden flex-shrink-0" style="height: 160px; background: #f0f0f0;">
  @if($photoUrl)
    <img src="{{ $photoUrl }}"
         alt="{{ $name }}"
         loading="lazy"
         class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-300"
         onerror="this.parentElement.innerHTML=this.parentElement.innerHTML.replace(this.outerHTML,'<img src=\'{{ $defaultAvatar }}\' class=\'mx-auto h-24 w-24 mt-4 object-contain\'>')">
  @else
    <div class="flex items-center justify-center h-full">
      <img src="{{ $defaultAvatar }}"
           alt="{{ $name }}"
           loading="lazy"
           class="h-24 w-24 object-contain">
    </div>
  @endif
                  <span class="absolute top-3 left-3 bg-black/50 backdrop-blur-sm text-white text-xs px-2.5 py-1 rounded-full font-medium">
                    {{ $memberId }}
                  </span>
                  @if($gender)
                    <span class="absolute top-3 right-3 text-xs px-2.5 py-1 rounded-full font-medium
                      {{ $gender === 'female' ? 'bg-pink-500/80 text-white' : 'bg-blue-500/80 text-white' }}">
                      <i class="fas fa-{{ $gender === 'female' ? 'venus' : 'mars' }} mr-1"></i>
                      {{ ucfirst($gender) }}
                    </span>
                  @endif
                </div>

                {{-- Card Body --}}
                <div class="p-4 flex flex-col flex-1">
                  <h3 class="font-bold text-gray-900 text-base mb-3 leading-snug">{{ $name }}</h3>

                  <div class="grid grid-cols-2 gap-x-4 gap-y-3 mb-3">

                    <div class="flex items-start gap-2">
                      <i class="fas fa-birthday-cake text-red-400 text-xs mt-1 flex-shrink-0"></i>
                      <div>
                        <p class="text-xs text-gray-400 leading-none mb-0.5">Age</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $age ? $age . ' yrs' : '—' }}</p>
                      </div>
                    </div>

                    <div class="flex items-start gap-2">
                      <i class="fas fa-briefcase text-red-400 text-xs mt-1 flex-shrink-0"></i>
                      <div>
                        <p class="text-xs text-gray-400 leading-none mb-0.5">Occupation</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $occupation ? ucwords(str_replace('_', ' ', $occupation)) : '—' }}</p>
                      </div>
                    </div>

                    <div class="flex items-start gap-2 col-span-2">
                      <i class="fas fa-graduation-cap text-red-400 text-xs mt-1 flex-shrink-0"></i>
                      <div>
                        <p class="text-xs text-gray-400 leading-none mb-0.5">Study Details</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $education ? ucwords(str_replace('_', ' ', $education)) : '—' }}</p>
                      </div>
                    </div>

                    <div class="flex items-start gap-2">
                      <i class="fas fa-ring text-red-400 text-xs mt-1 flex-shrink-0"></i>
                      <div>
                        <p class="text-xs text-gray-400 leading-none mb-0.5">Marital Status</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $marital ? ucwords(str_replace('_', ' ', $marital)) : '—' }}</p>
                      </div>
                    </div>

                    

                  </div>

                  <div class="flex-1"></div>

                  <div class="flex gap-2 mt-3">
                    <a href="/members/{{ $profileId }}"
                       class="flex-1 text-center text-sm font-semibold text-white py-2.5 rounded-xl transition hover:opacity-90"
                       style="background: linear-gradient(135deg, #7a1010, #a31c1c);">
                      <i class="fas fa-user mr-1 text-xs"></i> View Profile
                    </a>
                    <button onclick="sendInterest({{ $profileId }}, {{ $profileId }})"
                            class="flex-1 text-sm font-semibold border-2 border-pink-400 text-pink-500 hover:bg-pink-50 py-2.5 rounded-xl transition">
                      <i class="fas fa-heart mr-1 text-xs"></i> Interest
                    </button>
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          @if($lastPage > 1)
            <div class="mt-10 flex items-center justify-center gap-1.5 flex-wrap">
              @if($currentPage > 1)
                <a href="{{ request()->fullUrlWithQuery(['page' => $currentPage - 1]) }}"
                   class="px-3 py-2 text-sm rounded-xl border border-gray-200 hover:bg-gray-50 text-gray-600 transition">
                  <i class="fas fa-chevron-left text-xs"></i>
                </a>
              @endif
              @for($p = max(1, $currentPage - 2); $p <= min($lastPage, $currentPage + 2); $p++)
                <a href="{{ request()->fullUrlWithQuery(['page' => $p]) }}"
                   class="px-4 py-2 text-sm rounded-xl border transition font-medium
                          {{ $p === $currentPage ? 'text-white border-transparent' : 'border-gray-200 hover:bg-gray-50 text-gray-600' }}"
                   @if($p === $currentPage) style="background: linear-gradient(135deg, #7a1010, #a31c1c);" @endif>
                  {{ $p }}
                </a>
              @endfor
              @if($currentPage < $lastPage)
                <a href="{{ request()->fullUrlWithQuery(['page' => $currentPage + 1]) }}"
                   class="px-3 py-2 text-sm rounded-xl border border-gray-200 hover:bg-gray-50 text-gray-600 transition">
                  <i class="fas fa-chevron-right text-xs"></i>
                </a>
              @endif
            </div>
            <p class="text-center text-xs text-gray-400 mt-3">
              Page {{ $currentPage }} of {{ $lastPage }} &middot; {{ number_format($total) }} profiles
            </p>
          @endif

        @endif
      </main>
    </div>
  </div>
</div>

<div id="interest-toast"
     class="fixed bottom-6 right-6 bg-gray-900 text-white text-sm px-5 py-3 rounded-2xl shadow-2xl hidden z-50 flex items-center gap-2">
  <i class="fas fa-check-circle text-green-400"></i>
  <span id="interest-toast-msg"></span>
</div>

<script>
function sendInterest(memberId, profileId) {
  fetch('/members/' + memberId + '/interest', {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ profile_id: profileId })
  })
  .then(r => r.json())
  .then(data => showToast(data.message ?? 'Interest sent!', data.message?.toLowerCase().includes('already') || data.message?.toLowerCase().includes('could not') ? 'error' : 'success'))
  .catch(() => showToast('Something went wrong. Please try again.', 'error'));
}

function showToast(msg, type = 'success') {
  const toast = document.getElementById('interest-toast');
  const icon  = toast.querySelector('i');
  document.getElementById('interest-toast-msg').textContent = msg;
  icon.className = type === 'success' ? 'fas fa-check-circle text-green-400' : 'fas fa-exclamation-circle text-red-400';
  toast.classList.remove('hidden');
  toast.classList.add('flex');
  setTimeout(() => { toast.classList.add('hidden'); toast.classList.remove('flex'); }, 3500);
}
</script>
@endsection

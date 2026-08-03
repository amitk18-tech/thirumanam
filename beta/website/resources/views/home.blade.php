@extends('layouts.app')

@section('title', 'Home — Thirumanam')

@section('content')

{{-- ─── HERO SECTION ─── --}}
<div class="relative overflow-hidden" x-data="heroSlider()">

    {{-- Slide backgrounds --}}
    <div class="absolute inset-0">
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="current === index"
                x-transition:enter="transition-opacity duration-1000"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-1000"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0">
                <img :src="slide.img" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/70"></div>
            </div>
        </template>
    </div>

    {{-- Hero content --}}
    <div class="relative max-w-7xl mx-auto px-4 py-40 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 text-white text-sm px-4 py-1.5 rounded-full mb-6">
            <i class="fas fa-star text-yellow-400 text-xs"></i>
            {{ __('ui.hero_badge') }}
        </div>
        <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 leading-tight">
            {{ __('ui.hero_title') }}<br><span class="text-[#F24570]">{{ __('ui.hero_title_highlight') }}</span>
        </h1>
        <p class="text-lg text-gray-300 mb-10 max-w-xl mx-auto">
            {{ __('ui.hero_subtitle') }}
        </p>

        @if($isLoggedIn)
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ url('/members') }}" class="bg-[#F24570] text-white font-semibold px-8 py-3.5 rounded-full hover:bg-[#d63560] transition shadow-lg shadow-pink-900/30">
                <i class="fas fa-search mr-2"></i>{{ __('ui.browse_members') }}
            </a>
            <a href="{{ url('/profile/me') }}" class="bg-white/10 backdrop-blur-sm border border-white/30 text-white font-semibold px-8 py-3.5 rounded-full hover:bg-white/20 transition">
                <i class="fas fa-user mr-2"></i>{{ __('ui.my_profile') }}
            </a>
        </div>
        @else
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ url('/register') }}" class="bg-[#F24570] text-white font-semibold px-8 py-3.5 rounded-full hover:bg-[#d63560] transition shadow-lg shadow-pink-900/30">
                <i class="fas fa-user-plus mr-2"></i>{{ __('ui.register_free') }}
            </a>
            <a href="{{ url('/login') }}" class="bg-white/10 backdrop-blur-sm border border-white/30 text-white font-semibold px-8 py-3.5 rounded-full hover:bg-white/20 transition">
                <i class="fas fa-sign-in-alt mr-2"></i>{{ __('ui.login') }}
            </a>
        </div>
        @endif

        {{-- Slider dots --}}
        <div class="flex justify-center mt-10 space-x-2">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="current = index"
                    :class="current === index ? 'bg-[#F24570] w-6' : 'bg-white/40 w-3'"
                    class="h-3 rounded-full transition-all duration-300"></button>
            </template>
        </div>
    </div>
</div>

{{-- ─── STATS ─── --}}
<div class="bg-white py-12 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="group">
                <div class="text-4xl font-bold text-[#8B1A1A] mb-1 group-hover:text-[#F24570] transition">5000+</div>
                <div class="text-gray-500 text-sm">{{ __('ui.total_members') }}</div>
            </div>
            <div class="group">
                <div class="text-4xl font-bold text-[#8B1A1A] mb-1 group-hover:text-[#F24570] transition">3000+</div>
                <div class="text-gray-500 text-sm">{{ __('ui.online_members') }}</div>
            </div>
            <div class="group">
                <div class="text-4xl font-bold text-[#8B1A1A] mb-1 group-hover:text-[#F24570] transition">1500+</div>
                <div class="text-gray-500 text-sm">{{ __('ui.male_profiles') }}</div>
            </div>
            <div class="group">
                <div class="text-4xl font-bold text-[#8B1A1A] mb-1 group-hover:text-[#F24570] transition">1500+</div>
                <div class="text-gray-500 text-sm">{{ __('ui.female_profiles') }}</div>
            </div>
        </div>
    </div>
</div>

{{-- ─── MEMBERS CAROUSEL (logged in only) ─── --}}
@if(true)
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-gray-800">{{ __('ui.featured_members') }}</h2>
            <p class="text-gray-500 mt-2 text-sm">{{ __('ui.featured_members_sub') }}</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($showcaseMembers as $member)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group cursor-default">
                <div class="aspect-square overflow-hidden bg-gray-100 relative">
                    <img src="{{ $member['profile_photo'] }}" alt="{{ $member['name'] }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                        onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                    <div class="w-full h-full absolute inset-0 items-center justify-center bg-red-50 hidden">
                        <svg viewBox="0 0 100 120" xmlns="http://www.w3.org/2000/svg" class="w-3/4 h-3/4">
                            <circle cx="50" cy="32" r="18" fill="#c0392b" opacity="0.25"/>
                            <circle cx="50" cy="32" r="14" fill="#8B1A1A" opacity="0.4"/>
                            <rect x="22" y="58" width="56" height="30" rx="8" fill="#8B1A1A" opacity="0.2"/>
                        </svg>
                    </div>
                </div>
                <div class="p-3">
                    <div class="font-semibold text-gray-800 text-sm truncate">{{ $member['name'] }}</div>
                    <div class="text-xs text-[#8B1A1A] mt-0.5">{{ $member['age'] }} yrs &bull; {{ $member['education'] }}</div>
                    <div class="text-xs text-gray-400 mt-0.5 truncate">{{ $member['occupation'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-10">
            <a href="{{ url('/members') }}" class="bg-[#8B1A1A] text-white px-8 py-3 rounded-full hover:bg-[#6e1515] transition font-semibold">
                {{ __('ui.view_all_members') }} <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</div>
@endif

{{-- ─── GUEST CTA (not logged in) ─── --}}
@if(!$isLoggedIn)
<div class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-gradient-to-br from-[#8B1A1A] to-[#F24570] rounded-3xl p-10 text-center text-white shadow-xl">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-heart text-2xl text-white"></i>
            </div>
            <h2 class="text-3xl font-bold mb-3">{{ __('ui.begin_journey') }}</h2>
            <p class="text-red-100 mb-8 max-w-md mx-auto">{{ __('ui.begin_journey_sub') }}</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ url('/register') }}" class="bg-white text-[#8B1A1A] font-semibold px-8 py-3 rounded-full hover:bg-red-50 transition">
                    <i class="fas fa-user-plus mr-2"></i>{{ __('ui.register_free') }}
                </a>
                <a href="{{ url('/login') }}" class="border-2 border-white text-white font-semibold px-8 py-3 rounded-full hover:bg-white/10 transition">
                    <i class="fas fa-sign-in-alt mr-2"></i>{{ __('ui.login') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ─── HOW IT WORKS ─── --}}
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-2xl font-bold text-gray-800">{{ __('ui.how_it_works') }}</h2>
            <p class="text-gray-500 mt-2 text-sm">{{ __('ui.how_it_works_sub') }}</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 hover:shadow-md transition">
                <div class="w-16 h-16 bg-[#8B1A1A]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-plus text-2xl text-[#8B1A1A]"></i>
                </div>
                <div class="text-4xl font-bold text-[#F24570]/20 mb-2">01</div>
                <h3 class="font-bold text-gray-800 mb-2">{{ __('ui.step_register') }}</h3>
                <p class="text-gray-500 text-sm">{{ __('ui.step_register_desc') }}</p>
            </div>
            <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 hover:shadow-md transition">
                <div class="w-16 h-16 bg-[#8B1A1A]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search text-2xl text-[#8B1A1A]"></i>
                </div>
                <div class="text-4xl font-bold text-[#F24570]/20 mb-2">02</div>
                <h3 class="font-bold text-gray-800 mb-2">{{ __('ui.step_search') }}</h3>
                <p class="text-gray-500 text-sm">{{ __('ui.step_search_desc') }}</p>
            </div>
            <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 hover:shadow-md transition">
                <div class="w-16 h-16 bg-[#8B1A1A]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heart text-2xl text-[#8B1A1A]"></i>
                </div>
                <div class="text-4xl font-bold text-[#F24570]/20 mb-2">03</div>
                <h3 class="font-bold text-gray-800 mb-2">{{ __('ui.step_connect') }}</h3>
                <p class="text-gray-500 text-sm">{{ __('ui.step_connect_desc') }}</p>
            </div>
        </div>
    </div>
</div>

{{-- ─── WHY CHOOSE US ─── --}}
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-2xl font-bold text-gray-800">{{ __('ui.why_choose') }}</h2>
            <p class="text-gray-500 mt-2 text-sm">{{ __('ui.why_choose_sub') }}</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl p-6 border border-gray-100 hover:shadow-md transition text-center">
                <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-green-500 text-lg"></i>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">{{ __('ui.verified_profiles') }}</h4>
                <p class="text-gray-500 text-xs">{{ __('ui.verified_profiles_desc') }}</p>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-gray-100 hover:shadow-md transition text-center">
                <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-lock text-blue-500 text-lg"></i>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">{{ __('ui.privacy_first') }}</h4>
                <p class="text-gray-500 text-xs">{{ __('ui.privacy_first_desc') }}</p>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-gray-100 hover:shadow-md transition text-center">
                <div class="w-12 h-12 bg-yellow-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-star text-yellow-500 text-lg"></i>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">{{ __('ui.tamil_focused') }}</h4>
                <p class="text-gray-500 text-xs">{{ __('ui.tamil_focused_desc') }}</p>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-gray-100 hover:shadow-md transition text-center">
                <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-headset text-[#8B1A1A] text-lg"></i>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">{{ __('ui.dedicated_support') }}</h4>
                <p class="text-gray-500 text-xs">{{ __('ui.dedicated_support_desc') }}</p>
            </div>
        </div>
    </div>
</div>

{{-- ─── APP DOWNLOAD ─── --}}
<div class="py-16 bg-gradient-to-br from-[#8B1A1A] to-[#5a1010]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-10">
            <div class="text-white text-center md:text-left">
                <h2 class="text-3xl font-bold mb-2">{{ __('ui.app_download_title') }}</h2>
                <p class="text-red-200 mb-8 max-w-md">{{ __('ui.app_download_sub') }}</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="#" class="bg-black text-white px-6 py-3 rounded-xl flex items-center space-x-3 hover:bg-gray-900 transition border border-white/10">
                        <i class="fab fa-google-play text-2xl text-green-400"></i>
                        <div>
                            <div class="text-xs text-gray-400">{{ __('ui.get_it_on') }}</div>
                            <div class="font-semibold">Google Play</div>
                        </div>
                    </a>
                    <a href="#" class="bg-black text-white px-6 py-3 rounded-xl flex items-center space-x-3 hover:bg-gray-900 transition border border-white/10">
                        <i class="fab fa-apple text-2xl"></i>
                        <div>
                            <div class="text-xs text-gray-400">{{ __('ui.download_on_the') }}</div>
                            <div class="font-semibold">App Store</div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="flex gap-8 text-center text-white">
                <div>
                    <div class="text-4xl font-bold text-[#F24570]">5K+</div>
                    <div class="text-red-200 text-sm mt-1">{{ __('ui.app_downloads') }}</div>
                </div>
                <div class="w-px bg-white/20"></div>
                <div>
                    <div class="text-4xl font-bold text-[#F24570]">4.8★</div>
                    <div class="text-red-200 text-sm mt-1">{{ __('ui.user_rating') }}</div>
                </div>
                <div class="w-px bg-white/20"></div>
                <div>
                    <div class="text-4xl font-bold text-[#F24570]">500+</div>
                    <div class="text-red-200 text-sm mt-1">{{ __('ui.matches_made') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ─── CONTACT ─── --}}
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-gray-800">{{ __('ui.contact_title') }}</h2>
            <p class="text-gray-500 mt-2 text-sm">{{ __('ui.contact_sub') }}</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
            <div class="space-y-5">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-phone-alt text-[#8B1A1A]"></i>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400 uppercase tracking-wide">{{ __('ui.phone') }}</div>
                        <div class="font-semibold text-gray-800">(+91) 94878 33674 / (+91) 98942 78185</div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-envelope text-[#8B1A1A]"></i>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400 uppercase tracking-wide">{{ __('ui.email') }}</div>
                        <div class="font-semibold text-gray-800">service@thirumanam.info</div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ url('/contact') }}" class="bg-[#8B1A1A] text-white px-6 py-2.5 rounded-full hover:bg-[#6e1515] transition text-sm font-semibold inline-block">
                        <i class="fas fa-paper-plane mr-2"></i>{{ __('ui.send_message') }}
                    </a>
                </div>
            </div>
            <div class="rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7167.2879293178685!2d78.14167178799589!3d11.623953467429658!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTHCsDM3JzI4LjYiTiA3OMKwMDgnNDIuMCJF!5e0!3m2!1sen!2sin!4v1591188739729!5m2!1sen!2sin"
                    width="100%" height="280" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function heroSlider() {
    return {
        current: 0,
        slides: [
            { img: 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?w=1600&q=80' },
            { img: 'https://images.unsplash.com/photo-1679937698873-6065742c8d32?w=1600&q=80' },
            { img: 'https://images.unsplash.com/photo-1678705902081-5d55ab847046?w=1600&q=80' },
        ],
        init() {
            setInterval(() => {
                this.current = (this.current + 1) % this.slides.length;
            }, 6000);
        }
    }
}
</script>
@endpush

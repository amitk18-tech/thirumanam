{{-- TOP BAR --}}
<div class="bg-primary text-white text-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-10">

        {{-- Left: Phone --}}
        <div class="flex items-center gap-4">
            <a href="tel:+919487833674" class="hover:text-rose-200 flex items-center gap-1">
                <i class="fas fa-phone-alt text-xs"></i>
                <span class="hidden sm:inline">(+91) 94878 33674 / (+91) 98942 78185</span>
                <span class="sm:hidden">(+91) 94878 33674</span>
            </a>
        </div>

        {{-- Right: Auth actions or Language toggle --}}
        <div class="flex items-center gap-4">

            {{-- Language Toggle --}}
            <div class="flex items-center gap-1 border border-white/30 rounded-full px-2 py-0.5">
                <a href="{{ route('locale.switch', 'en') }}" class="text-xs px-2 py-0.5 rounded-full {{ app()->getLocale() == 'en' ? 'bg-white/20 text-white font-medium' : 'text-white/70 hover:text-white' }}">English</a>
                <a href="{{ route('locale.switch', 'ta') }}" class="text-xs px-2 py-0.5 rounded-full {{ app()->getLocale() == 'ta' ? 'bg-white/20 text-white font-medium' : 'text-white/70 hover:text-white' }}">தமிழ்</a>
            </div>

            @if(session('api_token'))
                <a href="{{ url('/messages') }}" class="relative hover:text-rose-200" title="{{ __('ui.messages') }}">
                    <i class="fas fa-comment-dots text-base"></i>
                    @if($tickerMsgCount > 0)
                        <span id="msg-badge" class="absolute -top-1.5 -right-1.5 bg-rose text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center leading-none">{{ $tickerMsgCount }}</span>
                    @endif
                </a>

                <a href="{{ url('/notifications') }}" class="relative hover:text-rose-200" title="{{ __('ui.notifications') }}">
                    <i class="fas fa-bell text-base"></i>
                    @if($tickerNotifCount > 0)
                        <span class="absolute -top-1.5 -right-1.5 bg-rose text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center leading-none">
                            {{ $tickerNotifCount }}
                        </span>
                    @endif
                </a>

                <div class="flex items-center gap-2">
                    @php $user = session('user'); @endphp
                    @php
                        $navUser = session('user');
                        $navPhoto = $navUser['profile_photo']
                            ?? $navUser['profile']['profile_photo']
                            ?? null;
                        if ($navPhoto && !str_starts_with($navPhoto, 'http')) {
                            $navPhoto = 'https://api.thirumanam.info/' . ltrim($navPhoto, '/');
                        }
                        $navName = $navUser['name']
                            ?? $navUser['profile']['user']['name']
                            ?? 'Member';
                    @endphp
                    @if($navPhoto && !str_contains($navPhoto, 'default_'))
                        <img src="{{ $navPhoto }}" class="w-7 h-7 rounded-full object-cover border-2 border-white/40">
                    @else
                        <div class="w-7 h-7 rounded-full bg-white/20 flex items-center justify-center">
                            <i class="fas fa-user text-xs"></i>
                        </div>
                    @endif
                    <span class="hidden sm:inline font-medium text-xs">{{ $navName }}</span>
                </div>

                <a href="{{ url('/logout') }}" class="hover:text-rose-200 flex items-center gap-1 text-xs">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="hidden sm:inline">{{ __('ui.logout') }}</span>
                </a>
            @endif
        </div>
    </div>
</div>

{{-- MAIN NAV --}}
<nav class="bg-white shadow-md sticky top-0 z-50" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-14">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center space-x-2">
                <img src="{{ asset('logo-ssam.png') }}" alt="Logo" class="h-9 w-9 object-contain rounded-full">
                <span class="text-sm font-bold text-primary leading-tight">{{ __('ui.contact_org_name') }}</span>
            </a>

            {{-- Desktop Menu --}}
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'text-primary font-semibold border-b-2 border-primary pb-0.5' : 'text-gray-700 hover:text-primary font-medium' }} text-sm">{{ __('ui.home') }}</a>
                @if(session('api_token'))
                    <a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard') ? 'text-primary font-semibold border-b-2 border-primary pb-0.5' : 'text-gray-700 hover:text-primary font-medium' }} text-sm">{{ __('ui.dashboard') }}</a>
                    <a href="{{ url('/members') }}" class="{{ request()->is('members*') ? 'text-primary font-semibold border-b-2 border-primary pb-0.5' : 'text-gray-700 hover:text-primary font-medium' }} text-sm">{{ __('ui.members') }}</a>
                @endif
                <a href="{{ url('/plans') }}" class="{{ request()->is('plans*') ? 'text-primary font-semibold border-b-2 border-primary pb-0.5' : 'text-gray-700 hover:text-primary font-medium' }} text-sm">{{ __('ui.plans') }}</a>
                <a href="{{ url('/contact') }}" class="{{ request()->is('contact*') ? 'text-primary font-semibold border-b-2 border-primary pb-0.5' : 'text-gray-700 hover:text-primary font-medium' }} text-sm">{{ __('ui.contact') }}</a>
                @if(!session('api_token'))
                    <a href="{{ url('/login') }}" class="text-gray-700 hover:text-primary font-medium text-sm">{{ __('ui.login') }}</a>
                    <a href="{{ url('/register') }}" class="bg-primary text-white px-4 py-2 rounded-full hover:bg-red-900 font-medium text-sm">{{ __('ui.register') }}</a>
                @endif
            </div>

            {{-- Mobile Menu Button --}}
            <button @click="open = !open" class="md:hidden text-gray-700">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        {{-- Mobile Dropdown Menu --}}
        <div x-show="open" x-transition class="md:hidden pb-4 space-y-2">
            <a href="{{ url('/') }}" class="block text-gray-700 hover:text-primary py-2 text-sm">{{ __('ui.home') }}</a>
            @if(session('api_token'))
                <a href="{{ url('/members') }}" class="block text-gray-700 hover:text-primary py-2 text-sm">{{ __('ui.members') }}</a>
                <a href="{{ url('/dashboard') }}" class="block text-gray-700 hover:text-primary py-2 text-sm">{{ __('ui.dashboard') }}</a>
            @endif
            <a href="{{ url('/plans') }}" class="block text-gray-700 hover:text-primary py-2 text-sm">{{ __('ui.plans') }}</a>
            <a href="{{ url('/contact') }}" class="block text-gray-700 hover:text-primary py-2 text-sm">{{ __('ui.contact') }}</a>
            @if(!session('api_token'))
                <a href="{{ url('/login') }}" class="block text-gray-700 hover:text-primary py-2 text-sm">{{ __('ui.login') }}</a>
                <a href="{{ url('/register') }}" class="block text-primary font-medium py-2 text-sm">{{ __('ui.register') }}</a>
            @else
                <a href="{{ url('/logout') }}" class="block text-red-600 font-medium py-2 text-sm">
                    <i class="fas fa-sign-out-alt mr-2"></i> {{ __('ui.logout') }}
                </a>
            @endif
        </div>
    </div>
</nav>

{{-- MOBILE BOTTOM NAV BAR (logged in only) --}}
@if(session('api_token'))
<div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 flex items-center justify-around h-14 shadow-lg">
    <a href="{{ url('/') }}" class="flex flex-col items-center justify-center text-{{ request()->is('/') ? 'primary' : 'gray-500' }} hover:text-primary flex-1 py-1">
        <i class="fas fa-home text-lg"></i>
        <span class="text-[10px] mt-0.5">{{ __('ui.home') }}</span>
    </a>
    <a href="{{ url('/members') }}" class="flex flex-col items-center justify-center text-{{ request()->is('members*') ? 'primary' : 'gray-500' }} hover:text-primary flex-1 py-1">
        <i class="fas fa-users text-lg"></i>
        <span class="text-[10px] mt-0.5">{{ __('ui.members') }}</span>
    </a>
    <a href="{{ url('/dashboard') }}" class="flex flex-col items-center justify-center text-{{ request()->is('dashboard') ? 'primary' : 'gray-500' }} hover:text-primary flex-1 py-1">
        <i class="fas fa-th-large text-lg"></i>
        <span class="text-[10px] mt-0.5">{{ __('ui.dashboard') }}</span>
    </a>
    <a href="{{ url('/notifications') }}" class="relative flex flex-col items-center justify-center text-{{ request()->is('notifications*') ? 'primary' : 'gray-500' }} hover:text-primary flex-1 py-1">
        <div class="relative">
            <i class="fas fa-bell text-lg"></i>
            @if($tickerNotifCount > 0)
                <span class="absolute -top-1.5 -right-1.5 bg-rose text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center leading-none">
                    {{ $tickerNotifCount }}
                </span>
            @endif
        </div>
        <span class="text-[10px] mt-0.5">{{ __('ui.alerts') }}</span>
    </a>
    <a href="{{ url('/profile/me') }}" class="flex flex-col items-center justify-center text-gray-500 hover:text-primary flex-1 py-1">
        <i class="fas fa-user text-lg"></i>
        <span class="text-[10px] mt-0.5">{{ __('ui.profile') }}</span>
    </a>
</div>
@endif

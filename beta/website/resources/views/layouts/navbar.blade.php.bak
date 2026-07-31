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

            {{-- Language Toggle (always visible) --}}
            <div class="flex items-center gap-1 border border-white/30 rounded-full px-2 py-0.5">
                <button class="text-white font-medium px-2 py-0.5 rounded-full bg-white/20 text-xs">English</button>
                <button class="text-white/70 hover:text-white px-2 py-0.5 text-xs">தமிழ்</button>
            </div>

            @if(session('api_token'))
                {{-- Messages --}}
                <a href="{{ url('/messages') }}" class="relative hover:text-rose-200" title="Messages">
                    <i class="fas fa-comment-dots text-base"></i>
                </a>

                {{-- Notifications --}}
                <a href="{{ url('/notifications') }}" class="relative hover:text-rose-200" title="Notifications">
                    <i class="fas fa-bell text-base"></i>
                </a>

                {{-- User Avatar + Name --}}
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

                {{-- Logout --}}
                <a href="{{ url('/logout') }}" class="hover:text-rose-200 flex items-center gap-1 text-xs">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="hidden sm:inline">Logout</span>
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
            <span class="text-sm font-bold text-primary leading-tight">Sri Sowdeswari Amman<br>Narpani Mandram</span>
            </a>

            {{-- Desktop Menu --}}
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'text-primary font-semibold border-b-2 border-primary pb-0.5' : 'text-gray-700 hover:text-primary font-medium' }} text-sm">Home</a>
                @if(session('api_token'))
                    <a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard') ? 'text-primary font-semibold border-b-2 border-primary pb-0.5' : 'text-gray-700 hover:text-primary font-medium' }} text-sm">Dashboard</a>
                    <a href="{{ url('/members') }}" class="{{ request()->is('members*') ? 'text-primary font-semibold border-b-2 border-primary pb-0.5' : 'text-gray-700 hover:text-primary font-medium' }} text-sm">Members</a>
                @endif
                <a href="{{ url('/plans') }}" class="{{ request()->is('plans*') ? 'text-primary font-semibold border-b-2 border-primary pb-0.5' : 'text-gray-700 hover:text-primary font-medium' }} text-sm">Plans</a>
                <a href="{{ url('/contact') }}" class="{{ request()->is('contact*') ? 'text-primary font-semibold border-b-2 border-primary pb-0.5' : 'text-gray-700 hover:text-primary font-medium' }} text-sm">Contact</a>
                @if(!session('api_token'))
                    <a href="{{ url('/login') }}" class="text-gray-700 hover:text-primary font-medium text-sm">Login</a>
                    <a href="{{ url('/register') }}" class="bg-primary text-white px-4 py-2 rounded-full hover:bg-red-900 font-medium text-sm">Register</a>
                @endif
            </div>

            {{-- Mobile Menu Button --}}
            <button @click="open = !open" class="md:hidden text-gray-700">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="open" x-transition class="md:hidden pb-4 space-y-2">
            <a href="{{ url('/') }}" class="block text-gray-700 hover:text-primary py-2 text-sm">Home</a>
            @if(session('api_token'))
                <a href="{{ url('/members') }}" class="block text-gray-700 hover:text-primary py-2 text-sm">Members</a>
                <a href="{{ url('/dashboard') }}" class="block text-gray-700 hover:text-primary py-2 text-sm">Dashboard</a>
            @endif
            <a href="{{ url('/plans') }}" class="block text-gray-700 hover:text-primary py-2 text-sm">Plans</a>
            <a href="{{ url('/contact') }}" class="block text-gray-700 hover:text-primary py-2 text-sm">Contact</a>
            @if(!session('api_token'))
                <a href="{{ url('/login') }}" class="block text-gray-700 hover:text-primary py-2 text-sm">Login</a>
                <a href="{{ url('/register') }}" class="block text-primary font-medium py-2 text-sm">Register</a>
            @else
                <a href="{{ url('/logout') }}" class="block text-red-600 font-medium py-2 text-sm">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
            @endif
        </div>
    </div>
</nav>

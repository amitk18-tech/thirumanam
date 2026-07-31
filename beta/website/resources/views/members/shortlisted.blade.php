@extends('layouts.app')

@section('title', 'Shortlisted Members')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Shortlisted Members</h1>
                <p class="text-gray-500 text-sm mt-1">Profiles you have shortlisted</p>
            </div>
            <a href="{{ url('/dashboard') }}" class="text-sm text-primary hover:underline">← Back to Dashboard</a>
        </div>

        @if(empty($profiles))
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-bookmark text-primary text-2xl"></i>
                </div>
                <p class="text-gray-500 text-sm">No shortlisted members yet.</p>
                <a href="{{ url('/members') }}" class="mt-4 inline-block bg-primary text-white text-sm font-semibold px-5 py-2 rounded-lg hover:bg-red-900 transition">
                    Browse Members
                </a>
            </div>
        @else
            <div class="space-y-3">
                @foreach($profiles as $p)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center space-x-4">
                    <div class="w-14 h-14 rounded-full overflow-hidden border border-gray-200 flex-shrink-0">
                        @if(!empty($p['photo']))
                            <img src="{{ $p['photo'] }}" alt="{{ $p['name'] }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-red-50 flex items-center justify-center">
                                <i class="fas fa-user text-primary text-xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-800 truncate">{{ $p['name'] }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            @if($p['member_no']) ID: {{ $p['member_no'] }} @endif
                            @if($p['age']) &bull; {{ $p['age'] }} yrs @endif
                            @if($p['gender']) &bull; {{ ucfirst($p['gender']) }} @endif
                        </p>
                        @if($p['occupation'] || $p['city'])
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ ucwords(str_replace('_', ' ', $p['occupation'] ?? '')) }}
                            @if($p['occupation'] && $p['city']) &bull; @endif
                            {{ $p['city'] ?? '' }}
                        </p>
                        @endif
                    </div>
                    <div class="flex-shrink-0">
                        @if($p['profile_id'])
                        <a href="{{ url('/members/' . $p['profile_id']) }}"
                           class="text-xs bg-primary text-white font-semibold px-3 py-1.5 rounded-lg hover:bg-red-900 transition">
                            View Profile
                        </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection

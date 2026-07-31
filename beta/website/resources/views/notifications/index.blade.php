@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <h1 class="text-2xl font-bold text-primary mb-6">
            <i class="fas fa-bell mr-2"></i> Notifications
        </h1>

        @if(empty($notifications))
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-10 text-center">
                <i class="fas fa-bell-slash text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">No notifications at this time.</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach($notifications as $notif)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-start gap-4">

                    {{-- Icon --}}
                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0
                        @if($notif['type'] === 'expiry_alert') bg-yellow-100
                        @elseif($notif['type'] === 'interest_received') bg-pink-100
                        @elseif($notif['type'] === 'new_follower') bg-green-100
                        @else bg-gray-100
                        @endif">
                        @if($notif['type'] === 'expiry_alert')
                            <i class="fas fa-clock text-yellow-500"></i>
                        @elseif($notif['type'] === 'interest_received')
                            <i class="fas fa-heart text-pink-500"></i>
                        @elseif($notif['type'] === 'new_follower')
                            <i class="fas fa-user-plus text-green-500"></i>
                        @else
                            <i class="fas fa-bell text-gray-400"></i>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800">{{ $notif['title'] }}</p>
                        <p class="text-sm text-gray-600 mt-0.5">{{ $notif['body'] }}</p>
                        <p class="text-xs text-gray-400 mt-1">
                            {{ \Carbon\Carbon::parse($notif['created_at'])->diffForHumans() }}
                        </p>
                    </div>

                    {{-- Action link --}}
                    @if($notif['type'] === 'interest_received' && !empty($notif['data']['sender_profile_id']))
                        <a href="{{ url('/members/' . $notif['data']['sender_profile_id']) }}"
                           class="text-xs text-primary font-semibold hover:underline flex-shrink-0">
                            View →
                        </a>
                    @elseif($notif['type'] === 'expiry_alert')
                        <a href="{{ url('/plans') }}"
                           class="text-xs text-primary font-semibold hover:underline flex-shrink-0">
                            Renew →
                        </a>
                    @endif

                </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection

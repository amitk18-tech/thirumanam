@if(!empty($tickerNotifications) && count($tickerNotifications) > 0)
<div class="bg-primary text-white text-sm overflow-hidden whitespace-nowrap" style="height:36px; line-height:36px;">
    <div class="flex items-center h-full">
        <span class="bg-rose px-3 py-0 font-bold shrink-0 h-full flex items-center z-10" style="letter-spacing:0.05em;">
            <i class="fa fa-bell mr-2"></i> ALERTS
        </span>
        <div class="overflow-hidden flex-1 relative">
            <div class="ticker-track flex gap-12 items-center" style="animation: ticker-scroll 30s linear infinite;">
                @foreach($tickerNotifications as $notif)
                    <span class="shrink-0">
                        @if($notif['type'] === 'expiry_alert')
                            <i class="fa fa-clock mr-1 text-yellow-300"></i>
                        @elseif($notif['type'] === 'interest_received')
                            <i class="fa fa-heart mr-1 text-pink-300"></i>
                        @elseif($notif['type'] === 'new_follower')
                            <i class="fa fa-user-plus mr-1 text-green-300"></i>
                        @endif
                        {{ $notif['body'] }}
                    </span>
                    <span class="shrink-0 text-rose opacity-60">&#9830;</span>
                @endforeach
                {{-- Duplicate for seamless loop --}}
                @foreach($tickerNotifications as $notif)
                    <span class="shrink-0">
                        @if($notif['type'] === 'expiry_alert')
                            <i class="fa fa-clock mr-1 text-yellow-300"></i>
                        @elseif($notif['type'] === 'interest_received')
                            <i class="fa fa-heart mr-1 text-pink-300"></i>
                        @elseif($notif['type'] === 'new_follower')
                            <i class="fa fa-user-plus mr-1 text-green-300"></i>
                        @endif
                        {{ $notif['body'] }}
                    </span>
                    <span class="shrink-0 text-rose opacity-60">&#9830;</span>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
@keyframes ticker-scroll {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.ticker-track {
    display: inline-flex;
    width: max-content;
}
.ticker-track:hover {
    animation-play-state: paused;
}
</style>
@endif

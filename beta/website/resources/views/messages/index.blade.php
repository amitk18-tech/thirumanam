@extends('layouts.app')

@section('title', 'Messages')

@section('content')
<div class="min-h-screen bg-gray-50" x-data="messagingApp()" x-init="init()">
    <div class="max-w-6xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-primary mb-6">Messages</h1>

        <div class="bg-white rounded-xl shadow overflow-hidden flex" style="height: 75vh;">

            {{-- LEFT: Conversation List --}}
            <div class="w-full md:w-1/3 border-r border-gray-200 flex flex-col">
                <div class="p-4 border-b border-gray-100 bg-gray-50">
                    <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Conversations</p>
                </div>

                <div class="overflow-y-auto flex-1">
                    @forelse($conversations as $conv)
                    <div
                        class="flex items-center gap-3 px-4 py-3 cursor-pointer hover:bg-rose-50 border-b border-gray-100 transition"
                        :class="selectedProfileId == {{ $conv['conversation_with_profile_id'] }} ? 'bg-rose-50 border-l-4 border-l-rose-500' : ''"
                        @click="openChat({{ $conv['conversation_with_profile_id'] }}, '{{ addslashes($conv['name'] ?? 'Unknown') }}', '{{ $conv['profile_photo'] ?? '' }}')"
                    >
                        <div class="relative flex-shrink-0">
                            <img
                                src="{{ $conv['profile_photo'] ?: asset('images/default_male.jpg') }}"
                                class="w-12 h-12 rounded-full object-cover border-2 border-gray-200"
                                onerror="this.src='{{ asset('images/default_male.jpg') }}'"
                            >
                            @if(!$conv['is_read'])
                            <span class="absolute top-0 right-0 w-3 h-3 bg-rose-500 rounded-full border-2 border-white"></span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-800 text-sm truncate">{{ $conv['name'] ?? 'Unknown' }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $conv['last_message'] ?? '' }}</p>
                        </div>
                        <div class="text-xs text-gray-400 flex-shrink-0">
                            {{ isset($conv['last_message_at']) ? \Carbon\Carbon::parse($conv['last_message_at'])->diffForHumans() : '' }}
                        </div>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center h-full py-16 text-gray-400">
                        <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <p class="text-sm">No conversations yet</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- RIGHT: Chat Window --}}
            <div class="flex-1 flex flex-col">

                {{-- No conversation selected --}}
                <template x-if="!selectedProfileId">
                    <div class="flex-1 flex flex-col items-center justify-center text-gray-400">
                        <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <p class="text-lg font-medium">Select a conversation</p>
                        <p class="text-sm mt-1">Choose from your conversations on the left</p>
                    </div>
                </template>

                {{-- Chat open --}}
                <template x-if="selectedProfileId">
                    <div class="flex flex-col h-full">

                        {{-- Chat header --}}
                        <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-200 bg-white">
                            <img :src="selectedPhoto || '{{ asset('images/default_male.jpg') }}'"
                                 class="w-10 h-10 rounded-full object-cover border border-gray-200"
                                 onerror="this.src='{{ asset('images/default_male.jpg') }}'">
                            <div>
                                <p class="font-semibold text-gray-800" x-text="selectedName"></p>
                                <p class="text-xs text-green-500">Active</p>
                            </div>
                        </div>

                        {{-- Messages --}}
                        <div class="flex-1 overflow-y-auto p-5 space-y-3 bg-gray-50" id="chatMessages">
                            <template x-if="loadingMessages">
                                <div class="flex justify-center py-8">
                                    <svg class="animate-spin w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                                    </svg>
                                </div>
                            </template>

                            <template x-for="msg in messages" :key="msg.id">
                                <div :class="msg.side === 'right' ? 'flex justify-end' : 'flex justify-start'">
                                    <div
                                        :class="msg.side === 'right'
                                            ? 'bg-primary text-white rounded-2xl rounded-tr-sm'
                                            : 'bg-white text-gray-800 rounded-2xl rounded-tl-sm shadow-sm'"
                                        class="max-w-xs lg:max-w-md px-4 py-2 text-sm"
                                    >
                                        <p x-text="msg.message_text"></p>
                                        <p class="text-xs mt-1 opacity-60 text-right" x-text="formatTime(msg.time)"></p>
                                    </div>
                                </div>
                            </template>

                            <template x-if="!loadingMessages && messages.length === 0">
                                <div class="text-center text-gray-400 text-sm py-8">No messages yet. Say hello!</div>
                            </template>
                        </div>

                        {{-- Send box --}}
                        <div class="px-4 py-3 border-t border-gray-200 bg-white">
                            <div class="flex items-center gap-3">
                                <input
                                    type="text"
                                    x-model="newMessage"
                                    @keydown.enter="sendMessage()"
                                    placeholder="Type a message..."
                                    class="flex-1 border border-gray-300 rounded-full px-4 py-2 text-sm focus:outline-none focus:border-primary"
                                    :disabled="sending"
                                >
                                <button
                                    @click="sendMessage()"
                                    :disabled="sending || !newMessage.trim()"
                                    class="bg-primary text-white rounded-full w-10 h-10 flex items-center justify-center hover:bg-red-900 transition disabled:opacity-50"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                </button>
                            </div>
                            <p x-show="errorMsg" x-text="errorMsg" class="text-xs text-red-500 mt-1 px-2"></p>
                        </div>

                    </div>
                </template>

            </div>
        </div>
    </div>
</div>

<script>
function messagingApp() {
    return {
        selectedProfileId: null,
        selectedName: '',
        selectedPhoto: '',
        messages: [],
        newMessage: '',
        sending: false,
        loadingMessages: false,
        errorMsg: '',
        pollTimer: null,

        init() {},

        openChat(profileId, name, photo) {
            this.selectedProfileId = profileId;
            this.selectedName = name;
            this.selectedPhoto = photo;
            this.messages = [];
            this.errorMsg = '';
            this.newMessage = '';
            if (this.pollTimer) clearInterval(this.pollTimer);
            this.loadChat();
            this.pollTimer = setInterval(() => this.loadChat(), 5000);
        },

        loadChat() {
            this.loadingMessages = true;
            fetch('{{ route("messages.chat") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ receiver_profile_id: this.selectedProfileId })
            })
            .then(r => r.json())
            .then(data => {
                this.messages = data.data || [];
                this.loadingMessages = false;
                this.$nextTick(() => this.scrollToBottom());
            })
            .catch(() => { this.loadingMessages = false; });
        },

        sendMessage() {
            if (!this.newMessage.trim() || this.sending) return;
            this.sending = true;
            this.errorMsg = '';
            const text = this.newMessage;
            this.newMessage = '';

            fetch('{{ route("messages.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    receiver_profile_id: this.selectedProfileId,
                    message_text: text
                })
            })
            .then(r => r.json())
            .then(data => {
                this.sending = false;
                if (data.success) {
                    this.loadChat();
                } else {
                    this.errorMsg = data.message || 'Failed to send message.';
                    this.newMessage = text;
                }
            })
            .catch(() => {
                this.sending = false;
                this.errorMsg = 'Network error. Please try again.';
                this.newMessage = text;
            });
        },

        scrollToBottom() {
            const el = document.getElementById('chatMessages');
            if (el) el.scrollTop = el.scrollHeight;
        },

        formatTime(iso) {
            if (!iso) return '';
            const d = new Date(iso);
            return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }
    }
}
</script>
@endsection

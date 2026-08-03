@extends('layouts.app')
@section('title', __('ui.privacy_title'))

@section('content')

{{-- Page Header --}}
<div class="bg-primary text-white py-12">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-3xl font-bold">{{ __('ui.privacy_title') }}</h1>
        <p class="mt-2 text-red-200">{{ __('ui.privacy_subtitle') }}</p>
    </div>
</div>

{{-- Content --}}
<div class="bg-gray-50 py-14">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="bg-white rounded-xl shadow-sm p-8 text-gray-600 text-sm leading-relaxed space-y-4">
            <p>{{ __('ui.privacy_intro') }}</p>

            <h2 class="text-lg font-bold text-primary pt-2">{{ __('ui.privacy_collect_heading') }}</h2>
            <p>{{ __('ui.privacy_collect_body') }}</p>

            <h2 class="text-lg font-bold text-primary pt-2">{{ __('ui.privacy_use_heading') }}</h2>
            <p>{{ __('ui.privacy_use_body') }}</p>

            <h2 class="text-lg font-bold text-primary pt-2">{{ __('ui.privacy_sharing_heading') }}</h2>
            <p>{{ __('ui.privacy_sharing_body') }}</p>

            <h2 class="text-lg font-bold text-primary pt-2">{{ __('ui.privacy_security_heading') }}</h2>
            <p>{{ __('ui.privacy_security_body') }}</p>

            <h2 class="text-lg font-bold text-primary pt-2">{{ __('ui.privacy_contact_heading') }}</h2>
            <p>{{ __('ui.privacy_contact_body') }}</p>

            <p class="text-xs text-gray-400 pt-4 border-t">{{ __('ui.privacy_footer_note') }}</p>
        </div>
    </div>
</div>

@endsection

@extends('layouts.app')
@section('title', __('ui.terms_title'))

@section('content')

{{-- Page Header --}}
<div class="bg-primary text-white py-12">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-3xl font-bold">{{ __('ui.terms_title') }}</h1>
        <p class="mt-2 text-red-200">{{ __('ui.terms_subtitle') }}</p>
    </div>
</div>

{{-- Content --}}
<div class="bg-gray-50 py-14">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="bg-white rounded-xl shadow-sm p-8 text-gray-600 text-sm leading-relaxed space-y-4">
            <p>By accessing and using Thirumanam (<strong>thirumanam.info</strong>), you accept and agree to be bound by the following terms and conditions.</p>

            <h2 class="text-lg font-bold text-primary pt-2">Membership Eligibility</h2>
            <p>Membership is open to Tamil community members who are of marriageable age. You must provide accurate and truthful information when creating your profile.</p>

            <h2 class="text-lg font-bold text-primary pt-2">Profile Guidelines</h2>
            <p>You are responsible for the content of your profile. Profiles found to contain false, misleading, or inappropriate information will be removed without notice.</p>

            <h2 class="text-lg font-bold text-primary pt-2">Payment & Refund Policy</h2>
            <p>Registration fees are non-refundable once paid. Membership is valid for 6 months or 100 profile views, whichever comes first.</p>

            <h2 class="text-lg font-bold text-primary pt-2">Privacy</h2>
            <p>Your personal information is protected as described in our Privacy Policy. Contact details are only shared between mutually interested members.</p>

            <h2 class="text-lg font-bold text-primary pt-2">Termination</h2>
            <p>We reserve the right to terminate any membership that violates these terms or is found to be fraudulent, without refund.</p>

            <h2 class="text-lg font-bold text-primary pt-2">Contact Us</h2>
            <p>For any questions regarding these terms, contact us at <a href="mailto:service@thirumanam.info" class="text-primary hover:underline">service@thirumanam.info</a>.</p>

            <p class="text-xs text-gray-400 pt-4 border-t">This page will be updated with the full terms provided by the site owner.</p>
        </div>
    </div>
</div>

@endsection

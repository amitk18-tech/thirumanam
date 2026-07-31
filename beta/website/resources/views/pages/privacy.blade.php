@extends('layouts.app')
@section('title', 'Privacy Policy')

@section('content')

{{-- Page Header --}}
<div class="bg-primary text-white py-12">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-3xl font-bold">Privacy Policy</h1>
        <p class="mt-2 text-red-200">How we collect, use and protect your information</p>
    </div>
</div>

{{-- Content --}}
<div class="bg-gray-50 py-14">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="bg-white rounded-xl shadow-sm p-8 text-gray-600 text-sm leading-relaxed space-y-4">
            <p>This Privacy Policy describes how Thirumanam (<strong>thirumanam.info</strong>) collects, uses, and shares information about you when you use our services.</p>

            <h2 class="text-lg font-bold text-primary pt-2">Information We Collect</h2>
            <p>We collect information you provide directly to us, such as when you create an account, fill out your profile, or contact us. This includes your name, mobile number, date of birth, and other profile details.</p>

            <h2 class="text-lg font-bold text-primary pt-2">How We Use Your Information</h2>
            <p>We use the information we collect to provide, maintain, and improve our services, to process payments, and to communicate with you about your account and our services.</p>

            <h2 class="text-lg font-bold text-primary pt-2">Information Sharing</h2>
            <p>We do not sell, trade, or otherwise transfer your personally identifiable information to outside parties without your consent, except as described in this policy.</p>

            <h2 class="text-lg font-bold text-primary pt-2">Data Security</h2>
            <p>We implement appropriate technical and organizational measures to protect the security of your personal information against unauthorized access, alteration, disclosure, or destruction.</p>

            <h2 class="text-lg font-bold text-primary pt-2">Contact Us</h2>
            <p>If you have any questions about this Privacy Policy, please contact us at <a href="mailto:service@thirumanam.info" class="text-primary hover:underline">service@thirumanam.info</a>.</p>

            <p class="text-xs text-gray-400 pt-4 border-t">This page will be updated with the full content provided by the site owner.</p>
        </div>
    </div>
</div>

@endsection

@extends('layouts.app')
@section('title', 'FAQ')

@section('content')

{{-- Page Header --}}
<div class="bg-primary text-white py-12">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-3xl font-bold">Common Queries</h1>
        <p class="mt-2 text-red-200">Frequently asked questions about Thirumanam</p>
    </div>
</div>

{{-- FAQ Content --}}
<div class="bg-gray-50 py-14">
    <div class="container mx-auto px-4 max-w-4xl">

        {{-- General FAQs --}}
        <div class="mb-10">
            <h2 class="text-xl font-bold text-primary mb-1">General Queries</h2>
            <div class="w-12 h-1 bg-rose rounded mb-6"></div>
            <div class="space-y-3">
                @foreach($generalFaqs as $faq)
                <details class="bg-white rounded-xl shadow-sm p-5 group">
                    <summary class="font-semibold text-gray-800 cursor-pointer list-none flex justify-between items-center">
                        {{ app()->getLocale() == 'ta' ? $faq['ta_q'] : $faq['en_q'] }}
                        <i class="fas fa-chevron-down text-primary text-sm ml-3 transition-transform group-open:rotate-180"></i>
                    </summary>
                    <p class="mt-3 text-gray-600 text-sm leading-relaxed">{{ app()->getLocale() == 'ta' ? $faq['ta_a'] : $faq['en_a'] }}</p>
                </details>
                @endforeach
            </div>
        </div>

        {{-- Online FAQs --}}
        <div class="mb-10">
            <h2 class="text-xl font-bold text-primary mb-1">Online Registered User Queries</h2>
            <div class="w-12 h-1 bg-rose rounded mb-6"></div>
            <div class="space-y-3">
                @foreach($onlineFaqs as $faq)
                <details class="bg-white rounded-xl shadow-sm p-5 group">
                    <summary class="font-semibold text-gray-800 cursor-pointer list-none flex justify-between items-center">
                        {{ app()->getLocale() == 'ta' ? $faq['ta_q'] : $faq['en_q'] }}
                        <i class="fas fa-chevron-down text-primary text-sm ml-3 transition-transform group-open:rotate-180"></i>
                    </summary>
                    <p class="mt-3 text-gray-600 text-sm leading-relaxed">{{ app()->getLocale() == 'ta' ? $faq['ta_a'] : $faq['en_a'] }}</p>
                </details>
                @endforeach
            </div>
        </div>

        {{-- Offline FAQs --}}
        <div class="mb-10">
            <h2 class="text-xl font-bold text-primary mb-1">Offline Registered User Queries</h2>
            <div class="w-12 h-1 bg-rose rounded mb-6"></div>
            <div class="space-y-3">
                @foreach($offlineFaqs as $faq)
                <details class="bg-white rounded-xl shadow-sm p-5 group">
                    <summary class="font-semibold text-gray-800 cursor-pointer list-none flex justify-between items-center">
                        {{ app()->getLocale() == 'ta' ? $faq['ta_q'] : $faq['en_q'] }}
                        <i class="fas fa-chevron-down text-primary text-sm ml-3 transition-transform group-open:rotate-180"></i>
                    </summary>
                    <p class="mt-3 text-gray-600 text-sm leading-relaxed">{{ app()->getLocale() == 'ta' ? $faq['ta_a'] : $faq['en_a'] }}</p>
                </details>
                @endforeach
            </div>
        </div>

    </div>
</div>

@endsection

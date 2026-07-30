@extends('layouts.app')
@section('title', 'Contact Us')

@section('content')

{{-- Page Header --}}
<div class="bg-primary text-white py-12">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-3xl font-bold">Contact Us</h1>
        <p class="mt-2 text-red-200">We're here to help you find your perfect match</p>
    </div>
</div>

{{-- Contact Info Cards --}}
<div class="bg-gray-50 py-14">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-primary">Contact Information</h2>
            <div class="w-16 h-1 bg-rose mx-auto mt-3 rounded"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-4xl mx-auto">

            {{-- Address --}}
            <div class="bg-white rounded-xl shadow-sm p-8 text-center hover:shadow-md transition">
                <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-map-marker-alt text-primary text-xl"></i>
                </div>
                <h6 class="font-semibold text-gray-800 mb-2">Address</h6>
                <p class="text-gray-500 text-sm leading-relaxed">
                    <span class="font-semibold text-gray-700">Sri Sowdeswari Amman Narpani Mandram</span><br>
                    <span class="text-xs text-gray-400">(Manage by Alagirisamy Vijayalakshmi Charitable Trust)</span><br><br>
                    Sri Vijayalakshmi Mahal Thirumana Mandapam<br>
                    32/1 Chinnusamy Nagar Main Road,<br>
                    (Behind Dharan Hospital),<br>
                    Seelanaickenpatty,<br>
                    Salem – 636 201.
                </p>
            </div>

            {{-- Phone --}}
            <div class="bg-white rounded-xl shadow-sm p-8 text-center hover:shadow-md transition">
                <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-phone-alt text-primary text-xl"></i>
                </div>
                <h6 class="font-semibold text-gray-800 mb-3">Phone</h6>
                <a href="tel:+919487833674" class="block text-primary hover:underline text-sm mb-1">(+91) 94878 33674</a>
                <a href="https://api.whatsapp.com/send?phone=+919894278185&text=" target="_blank"
                   class="inline-flex items-center gap-1 text-green-600 hover:underline text-sm mt-1">
                    <i class="fab fa-whatsapp"></i> (+91) 98942 78185
                </a>
            </div>

            {{-- Email --}}
            <div class="bg-white rounded-xl shadow-sm p-8 text-center hover:shadow-md transition">
                <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-envelope text-primary text-xl"></i>
                </div>
                <h6 class="font-semibold text-gray-800 mb-2">Email</h6>
                <a href="mailto:service@thirumanam.info" class="text-primary hover:underline text-sm">
                    service@thirumanam.info
                </a>
            </div>

        </div>
    </div>
</div>

{{-- Contact Form + Map --}}
<div class="bg-white py-14">
    <div class="container mx-auto px-4">

        {{-- Form --}}
        <div class="max-w-2xl mx-auto mb-12">
            <h2 class="text-2xl font-bold text-center text-primary mb-2">Send Us a Message</h2>
            <div class="w-16 h-1 bg-rose mx-auto mb-8 rounded"></div>

            @if(session('contact_success'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg px-5 py-4 mb-6 text-sm">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('contact_success') }}
                </div>
            @endif

            @if(session('contact_error'))
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-5 py-4 mb-6 text-sm">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ session('contact_error') }}
                </div>
            @endif

            <form action="/contact" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Your Name <span class="text-rose">*</span></label>
                    <input type="text" name="name" required value="{{ old('name') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                        placeholder="Enter your full name">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-rose">*</span></label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                        placeholder="Enter your email">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subject <span class="text-rose">*</span></label>
                    <input type="text" name="subject" required value="{{ old('subject') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                        placeholder="What is this about?">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Message <span class="text-rose">*</span></label>
                    <textarea name="message" rows="5" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                        placeholder="Write your message here...">{{ old('message') }}</textarea>
                </div>
                <button type="submit"
                    class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-red-900 transition text-sm">
                    <i class="fas fa-paper-plane mr-2"></i> Send Message
                </button>
            </form>
        </div>

        {{-- Google Map --}}
        <div class="rounded-xl overflow-hidden shadow-sm max-w-4xl mx-auto">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7167.2879293178685!2d78.14167178799589!3d11.623953467429658!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTHCsDM3JzI4LjYiTiA3OMKwMDgnNDIuMCJF!5e0!3m2!1sen!2sin!4v1591188739729!5m2!1sen!2sin"
                width="100%" height="380" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"
                class="w-full">
            </iframe>
        </div>

    </div>
</div>

@endsection

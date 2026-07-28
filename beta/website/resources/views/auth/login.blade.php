@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="text-3xl font-bold text-primary">திருமணம்</a>
            <p class="text-gray-500 mt-2">Login to your account</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            {{-- Error --}}
            @if($errors->has('login'))
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-6 text-sm">
                    {{ $errors->first('login') }}
                </div>
            @endif

            {{-- Success --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ url('/login') }}" x-data="{ showPassword: false }">
                @csrf

                {{-- Phone --}}
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mobile Number</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <i class="fas fa-phone-alt"></i>
                        </span>
                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="Enter your mobile number"
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm"
                            required>
                    </div>
                </div>

                {{-- Password --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input
                            :type="showPassword ? 'text' : 'password'"
                            name="password"
                            placeholder="Enter your password"
                            class="w-full pl-10 pr-10 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm"
                            required>
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-red-900 transition text-sm">
                    Login
                </button>

                {{-- Links --}}
                <div class="mt-4 text-center text-sm text-gray-500">
                    <a href="{{ url('/forgot-password') }}" class="text-primary hover:underline">Forgot Password?</a>
                </div>

                <div class="mt-4 text-center text-sm text-gray-500">
                    Don't have an account?
                    <a href="{{ url('/register') }}" class="text-primary font-semibold hover:underline">Register Free</a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection

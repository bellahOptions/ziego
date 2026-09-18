@extends('layouts.app')
@section('title', 'Forgot Password — Ziego Furniture')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-20" style="background: var(--cream);">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="h-2" style="background: linear-gradient(90deg, var(--brand-dark), var(--brand), var(--gold));"></div>

            <div class="p-8">
                <div class="text-center mb-8">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center mx-auto mb-4" style="background: var(--brand-pale);">
                        <svg class="w-7 h-7" fill="none" stroke="var(--brand)" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                    </div>
                    <h1 class="text-2xl font-bold" style="font-family: 'Calistoga', serif; color: var(--brand-dark);">Forgot Password?</h1>
                    <p class="text-gray-400 text-sm mt-2">Enter your email and we'll send you a link to reset your password.</p>
                </div>

                @if(session('success'))
                    <div class="alert-success text-xs px-3 py-2 mb-4 text-center">{{ session('success') }}</div>
                @endif

                <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus class="form-input" placeholder="you@example.com">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="btn-primary w-full justify-center mt-2">
                        Send Reset Link
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>
                </form>

                <p class="text-center text-sm text-gray-400 mt-6">
                    Remembered your password?
                    <a href="{{ route('login') }}" class="font-semibold hover:underline" style="color: var(--brand);">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

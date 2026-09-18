@extends('layouts.app')
@section('title', 'Register — Ziego Furniture')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-20" style="background: var(--cream);">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="h-2" style="background: linear-gradient(90deg, var(--brand-dark), var(--brand), var(--gold));"></div>

            <div class="p-8">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold" style="font-family: 'Calistoga', serif; color: var(--brand-dark);">Create Account</h1>
                    <p class="text-gray-400 text-sm mt-1">Join Ziego Furniture & Interiors</p>
                </div>

                <form action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="form-input" placeholder="John Doe">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label">Email Address *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="form-input" placeholder="you@example.com">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-input" placeholder="09137652910">
                    </div>

                    <div>
                        <label class="form-label">Company / Organisation</label>
                        <input type="text" name="company" value="{{ old('company') }}" class="form-input" placeholder="Optional">
                    </div>

                    <div>
                        <label class="form-label">Password *</label>
                        <input type="password" name="password" required class="form-input" placeholder="Min. 8 characters">
                        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label">Confirm Password *</label>
                        <input type="password" name="password_confirmation" required class="form-input" placeholder="Repeat password">
                    </div>

                    <button type="submit" class="btn-primary w-full justify-center mt-2">
                        Create Account
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    </button>
                </form>

                <p class="text-center text-sm text-gray-400 mt-6">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-semibold hover:underline" style="color: var(--brand);">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

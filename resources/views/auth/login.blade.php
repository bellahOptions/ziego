@extends('layouts.app')
@section('title', 'Login — Ziego Furniture')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-20" style="background: var(--cream);">
    <div class="w-full max-w-md">
        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            {{-- Top accent --}}
            <div class="h-2" style="background: linear-gradient(90deg, var(--brand-dark), var(--brand), var(--gold));"></div>

            <div class="p-8">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold" style="font-family: 'Calistoga', serif; color: var(--brand-dark);">Welcome Back</h1>
                    <p class="text-gray-400 text-sm mt-1">Sign in to your Ziego account</p>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus class="form-input" placeholder="you@example.com">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <label class="form-label mb-0">Password</label>
                            <a href="{{ route('password.request') }}" class="text-xs font-medium hover:underline" style="color: var(--brand);">Forgot password?</a>
                        </div>
                        <input type="password" name="password" required class="form-input" placeholder="••••••••">
                        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="remember" id="remember" class="rounded" style="accent-color: var(--brand);">
                        <label for="remember" class="text-sm text-gray-500">Remember me</label>
                    </div>

                    <button type="submit" class="btn-primary w-full justify-center mt-2">
                        Sign In
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>
                </form>

                <p class="text-center text-sm text-gray-400 mt-6">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-semibold hover:underline" style="color: var(--brand);">Create one</a>
                </p>
            </div>
        </div>

        <p class="text-center text-xs text-gray-400 mt-6">
            By signing in you agree to our terms of service.
        </p>
    </div>
</div>
@endsection

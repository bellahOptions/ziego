@extends('layouts.app')
@section('title', 'Reset Password — Ziego Furniture')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-20" style="background: var(--cream);">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="h-2" style="background: linear-gradient(90deg, var(--brand-dark), var(--brand), var(--gold));"></div>

            <div class="p-8">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold" style="font-family: 'Calistoga', serif; color: var(--brand-dark);">Reset Password</h1>
                    <p class="text-gray-400 text-sm mt-1">Choose a new password for your account</p>
                </div>

                <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div>
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $email) }}" required autofocus class="form-input" placeholder="you@example.com">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" required class="form-input" placeholder="••••••••">
                        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" required class="form-input" placeholder="••••••••">
                    </div>

                    <button type="submit" class="btn-primary w-full justify-center mt-2">
                        Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

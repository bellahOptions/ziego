@extends('layouts.app')
@section('title', 'Verify Email — Ziego Furniture')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-20" style="background: var(--cream);">
    <div class="w-full max-w-md">
        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            {{-- Top accent --}}
            <div class="h-2" style="background: linear-gradient(90deg, var(--brand-dark), var(--brand), var(--gold));"></div>

            <div class="p-8">
                <div class="text-center mb-6">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center mx-auto mb-4" style="background: var(--brand-pale);">
                        <svg class="w-7 h-7" fill="none" stroke="var(--brand)" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h1 class="text-2xl font-bold" style="font-family: 'Calistoga', serif; color: var(--brand-dark);">Verify Your Email</h1>
                    <p class="text-gray-400 text-sm mt-2 leading-relaxed">
                        We sent a verification link to <span class="font-semibold" style="color: var(--brand-dark);">{{ auth()->user()->email }}</span>.
                        Please check your inbox and click the link to activate your account.
                    </p>
                </div>

                @if (session('success'))
                    <div class="alert-success text-xs px-3 py-2 mb-4 text-center">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert-error text-xs px-3 py-2 mb-4 text-center">{{ session('error') }}</div>
                @endif

                <form action="{{ route('verification.send') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-primary w-full justify-center">
                        Resend Verification Email
                    </button>
                </form>

                <form action="{{ route('logout') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full text-center py-2.5 rounded-lg text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors">
                        Log Out
                    </button>
                </form>
            </div>
        </div>

        <p class="text-center text-xs text-gray-400 mt-6">
            Didn't get the email? Check your spam folder or click resend above.
        </p>
    </div>
</div>
@endsection

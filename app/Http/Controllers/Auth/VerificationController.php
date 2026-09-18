<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class VerificationController extends Controller
{
    public function notice()
    {
        return auth()->user()->hasVerifiedEmail()
            ? redirect()->route('home')
            : view('auth.verify-email');
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('home')->with('success', 'Your email has been verified.');
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        $key = 'verification-resend:' . $request->user()->id;

        if (RateLimiter::tooManyAttempts($key, 1)) {
            return back()->with('error', 'Please wait a minute before requesting another verification link.');
        }

        RateLimiter::hit($key, 60);

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'A new verification link has been sent to your email address.');
    }
}

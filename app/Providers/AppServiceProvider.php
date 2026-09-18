<?php

namespace App\Providers;

use App\Mail\SecurityNoticeMail;
use App\Models\Cart;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Livewire\Mechanisms\HandleRequests\RequireLivewireHeaders;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        Event::listen(Login::class, function (Login $event): void {
            $this->mergeGuestCartIntoUserCart($event);
        });

        // Rate-limit every Livewire component action (add-to-cart, wishlist toggle,
        // product search, admin forms, etc.) site-wide from a single choke point.
        app('livewire')->setUpdateRoute(function ($handle, $path) {
            return Route::post($path, $handle)
                ->middleware(['web', RequireLivewireHeaders::class, 'throttle:120,1']);
        });

        ResetPassword::toMailUsing(function ($notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new SecurityNoticeMail(
                mailSubject: 'Reset Your Password',
                heading: 'Reset Your Password',
                intro: 'We received a request to reset the password for your account. Click the button below to choose a new one.',
                buttonText: 'Reset Password',
                buttonUrl: $url,
                closingNote: "If you didn't request a password reset, no further action is required — your password will stay the same.",
                icon: 'lock',
                expiryNote: 'This link will expire in ' . config('auth.passwords.users.expire', 60) . ' minutes.',
            ))->to($notifiable->getEmailForPasswordReset());
        });

        VerifyEmail::toMailUsing(function ($notifiable, string $url) {
            return (new SecurityNoticeMail(
                mailSubject: 'Verify Your Email Address',
                heading: 'Verify Your Email',
                intro: "Thanks for joining Ziego! Please confirm your email address to activate your account and start shopping.",
                buttonText: 'Verify Email Address',
                buttonUrl: $url,
                closingNote: "If you didn't create an account, no further action is required.",
                icon: 'check',
            ))->to($notifiable->getEmailForVerification());
        });
    }

    private function mergeGuestCartIntoUserCart(Login $event): void
    {
        $guestCart = Cart::whereNull('user_id')
            ->where('session_id', session()->getId())
            ->with('items')
            ->first();

        if (!$guestCart || $guestCart->items->isEmpty()) {
            return;
        }

        $userCart = Cart::firstOrCreate(['user_id' => $event->user->id]);

        foreach ($guestCart->items as $item) {
            $existing = $userCart->items()->where('product_id', $item->product_id)->first();

            if ($existing) {
                $maxStock = $item->product?->stock ?? ($existing->quantity + $item->quantity);
                $existing->update(['quantity' => min($existing->quantity + $item->quantity, $maxStock)]);
            } else {
                $item->update(['cart_id' => $userCart->id]);
            }
        }

        $guestCart->delete();
    }
}

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ziego Furniture & Interiors — Furniture That Speaks Style')</title>
    <meta name="description" content="@yield('description', 'Premium furniture and interior solutions. Bulk orders, wholesale prices, nationwide delivery across Nigeria. RC: 9093335.')">

    {{-- Favicons --}}
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#341C02">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#341C02">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.5.0/model-viewer.min.js"></script>

    <style>[x-cloak] { display: none !important; }</style>
    @stack('head')
</head>
<body class="antialiased" x-data="{ mobileMenu: false }">

{{-- NAVIGATION --}}
<nav class="nav-glass fixed top-0 left-0 right-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-16 md:h-20">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center flex-shrink-0">
                <img src="/logo-dark-13.png" alt="Ziego Furniture & Interiors" class="h-10 w-auto">
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
                <a href="{{ route('products.index') }}" class="nav-link">Products</a>
                <a href="{{ route('showroom') }}" class="nav-link">3D Showroom</a>
                <a href="{{ route('about') }}" class="nav-link">About</a>
                <a href="{{ route('contact') }}" class="nav-link">Contact</a>
                <a href="{{ route('onepage') }}" class="nav-link">Onepage</a>
            </div>

            {{-- Right side --}}
            <div class="flex items-center gap-3">
                {{-- Wishlist --}}
                @auth
                    <livewire:wishlist.wishlist-icon />
                @endauth

                {{-- Cart --}}
                <livewire:cart.cart-icon />

                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 text-white hover:text-yellow-400 transition-colors text-sm font-medium">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm" style="background: var(--brand);">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <svg class="w-4 h-4 opacity-60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" x-cloak @click.away="open = false"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 py-1 z-50"
                             x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                    Admin Panel
                                </a>
                            @endif
                            <a href="{{ route('orders.index') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                My Orders
                            </a>
                            <hr class="my-1 border-gray-100">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 text-left">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden md:inline-flex btn-gold btn-sm">Login</a>
                @endauth

                {{-- Mobile menu toggle --}}
                <button @click="mobileMenu = !mobileMenu" class="md:hidden text-white p-2">
                    <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileMenu" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Mobile Nav --}}
        <div x-show="mobileMenu" x-cloak
             class="md:hidden py-4 border-t border-white/10"
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex flex-col gap-1">
                <a href="{{ route('home') }}" class="nav-link py-3 px-2 border-b border-white/5">Home</a>
                <a href="{{ route('products.index') }}" class="nav-link py-3 px-2 border-b border-white/5">Products</a>
                <a href="{{ route('showroom') }}" class="nav-link py-3 px-2 border-b border-white/5">3D Showroom</a>
                <a href="{{ route('about') }}" class="nav-link py-3 px-2 border-b border-white/5">About</a>
                <a href="{{ route('contact') }}" class="nav-link py-3 px-2 border-b border-white/5">Contact</a>
                <a href="{{ route('onepage') }}" class="nav-link py-3 px-2">Onepage</a>
                @guest
                    <div class="pt-4 flex gap-2">
                        <a href="{{ route('login') }}" class="btn-gold btn-sm flex-1 justify-center">Login</a>
                        <a href="{{ route('register') }}" class="btn-outline btn-sm flex-1 justify-center">Register</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>

@include('partials.flash-toasts')

{{-- PAGE CONTENT --}}
<main>
    @yield('content')
</main>

@include('partials.site-footer')

@include('partials.whatsapp-float')

@stack('scripts')
</body>
</html>

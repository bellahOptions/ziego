@php
    // Build the scrollspy nav from sections that will actually render, so a
    // nav item never points at a section that got skipped for lack of data.
    $navSections = collect([
        ['id' => 'home', 'label' => 'Home'],
        ['id' => 'shop', 'label' => 'Shop'],
        ['id' => 'showroom', 'label' => 'Showroom'],
        ['id' => 'about', 'label' => 'About'],
        $testimonials->isNotEmpty() ? ['id' => 'testimonials', 'label' => 'Reviews'] : null,
        ['id' => 'contact', 'label' => 'Contact'],
    ])->filter()->values();
@endphp
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ziego Furniture & Interiors — The Full Collection, One Scroll</title>
    <meta name="description" content="Shop, tour our 3D showroom and get in touch — Ziego Furniture & Interiors' entire catalog on a single continuously scrolling page, with new pieces loading automatically as you browse.">

    {{-- Favicons --}}
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#341C02">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.5.0/model-viewer.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        model-viewer { width: 100%; height: 100%; background: transparent; --poster-color: transparent; }
    </style>
</head>
<body class="antialiased" x-data="{ mobileMenu: false }">

<a href="#shop" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-[100] focus:bg-white focus:text-sm focus:font-semibold focus:px-4 focus:py-2 focus:rounded-lg" style="color: var(--brand-dark);">
    Skip to shop
</a>

{{-- SCROLL PROGRESS --}}
<div class="scroll-progress" style="width: 0%;"
     x-data
     x-init="
        let bar = $el;
        let update = () => {
            let h = document.documentElement;
            let scrolled = h.scrollTop;
            let height = h.scrollHeight - h.clientHeight;
            bar.style.width = (height > 0 ? (scrolled / height) * 100 : 0) + '%';
        };
        update();
        window.addEventListener('scroll', update, { passive: true });
        window.addEventListener('resize', update);
     "></div>

{{-- NAVIGATION (scrollspy) --}}
<nav class="nav-glass fixed top-0 left-0 right-0 z-50"
     x-data='{
        active: "home",
        sections: @json($navSections->pluck("id")),
        init() {
            let observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) { this.active = entry.target.id; }
                });
            }, { rootMargin: "-35% 0px -55% 0px", threshold: 0 });
            this.sections.forEach((id) => {
                let el = document.getElementById(id);
                if (el) observer.observe(el);
            });
        }
     }'>
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-16 md:h-20">

            <a href="{{ route('home') }}" class="flex items-center flex-shrink-0">
                <img src="/logo-dark-13.png" alt="Ziego Furniture & Interiors" class="h-10 w-auto">
            </a>

            {{-- Desktop scrollspy nav --}}
            <div class="hidden md:flex items-center gap-7">
                @foreach($navSections as $section)
                <a href="#{{ $section['id'] }}"
                   class="nav-link-onepage"
                   :class="active === '{{ $section['id'] }}' ? 'active' : ''"
                   :aria-current="active === '{{ $section['id'] }}' ? 'true' : 'false'">{{ $section['label'] }}</a>
                @endforeach
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="hidden lg:inline-flex nav-link text-xs opacity-70 hover:opacity-100">Full Site</a>

                @auth
                    <livewire:wishlist.wishlist-icon />
                @endauth
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

                <button @click="mobileMenu = !mobileMenu" class="md:hidden text-white p-2">
                    <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileMenu" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Mobile nav --}}
        <div x-show="mobileMenu" x-cloak @click="mobileMenu = false"
             class="md:hidden py-4 border-t border-white/10"
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex flex-col gap-1">
                @foreach($navSections as $section)
                <a href="#{{ $section['id'] }}" class="nav-link py-3 px-2 border-b border-white/5">{{ $section['label'] }}</a>
                @endforeach
                <a href="{{ route('home') }}" class="nav-link py-3 px-2 {{ auth()->guest() ? 'border-b border-white/5' : '' }}">Full Site</a>
                @guest
                    <a href="{{ route('login') }}" class="nav-link py-3 px-2" style="color: var(--gold);">Login</a>
                @endguest
            </div>
        </div>
    </div>
</nav>

@include('partials.flash-toasts')

<main>

{{-- ============ HERO ============ --}}
@php
    $heroSlides = [
        
        [
            'image' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=1920&q=90&fit=crop',
            'badge' => 'Bedroom Collection',
            'heading' => 'Transform Your<br><span style="color: var(--gold);">Bedroom</span>',
            'text' => 'Luxury beds, wardrobes and bedroom sets crafted for comfort and elegance — scroll down and they\'re already waiting in the shop.',
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?w=1920&q=90&fit=crop',
            'badge' => 'Office Furniture',
            'heading' => 'Elevate Your<br><span style="color: var(--gold);">Workspace</span>',
            'text' => 'Executive desks, ergonomic chairs and conference furniture — equip your office without ever leaving this page.',
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1586023492157-ac6decaa0b0c?w=1920&q=90&fit=crop',
            'badge' => 'Wholesale & Bulk Orders',
            'heading' => 'Best Prices for<br><span style="color: var(--gold);">Bulk Orders</span>',
            'text' => 'Unbeatable wholesale prices for hotels, schools and offices, with nationwide delivery to all 36 states.',
        ],
    ];
@endphp
<section id="home" tabindex="-1" class="relative overflow-hidden"
    x-data="{
        current: 0,
        total: {{ count($heroSlides) }},
        paused: false,
        timer: null,
        next() { this.current = (this.current + 1) % this.total },
        prev() { this.current = (this.current - 1 + this.total) % this.total },
        go(i) { this.current = i },
        init() {
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
            this.timer = setInterval(() => { if (!this.paused) this.next(); }, 6000);
        }
    }"
    @mouseenter="paused = true" @mouseleave="paused = false"
    @focusin="paused = true" @focusout="paused = false"
    style="min-height: 100vh;">

    {{-- Slides --}}
    @foreach($heroSlides as $i => $slide)
    <div x-show="current === {{ $i }}" @if($i > 0) x-cloak @endif
         x-transition:enter="transition-opacity duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="absolute inset-0">
        <img src="{{ $slide['image'] }}" alt="" class="w-full h-full object-cover">
        <div class="hero-overlay"></div>
    </div>
    @endforeach

    <div class="relative z-10 flex flex-col items-center justify-center text-center" style="min-height: 100vh; padding-top: 6rem;">
        <div class="max-w-2xl px-4 sm:px-6 py-16">

            {{-- Per-slide badge / heading / copy --}}
            @foreach($heroSlides as $i => $slide)
            <div x-show="current === {{ $i }}" @if($i > 0) x-cloak @endif
                 x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                
                <h1 class="hero-title text-4xl md:text-5xl lg:text-6xl text-white mb-6">{!! $slide['heading'] !!}</h1>
                <p class="text-lg text-white/75 mb-10 max-w-xl mx-auto leading-relaxed">{{ $slide['text'] }}</p>
            </div>
            @endforeach

            <div class="flex flex-wrap justify-center gap-4 mb-12">
                <a href="#shop" class="btn-gold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    Start Shopping
                </a>
                <a href="#showroom" class="btn-outline">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/></svg>
                    Tour the Showroom
                </a>
            </div>
        </div>
    </div>

    {{-- Slide dots --}}
    <div class="absolute bottom-24 left-1/2 -translate-x-1/2 z-20 flex gap-2 items-center">
        @foreach($heroSlides as $i => $slide)
        <button @click="go({{ $i }})" type="button" aria-label="Show slide {{ $i + 1 }}: {{ $slide['badge'] }}"
                class="slide-dot h-1 transition-all duration-300" :class="current === {{ $i }} ? 'active w-8' : 'w-4'" style="min-width: 1rem;"></button>
        @endforeach
    </div>

    {{-- Prev / next arrows --}}
    <button @click="prev()" type="button" aria-label="Previous slide" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full flex items-center justify-center hover:scale-110 transition-transform" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(4px);">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button @click="next()" type="button" aria-label="Next slide" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full flex items-center justify-center hover:scale-110 transition-transform" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(4px);">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
    </button>

    <a href="#shop" class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 flex flex-col items-center gap-2 text-white/60 hover:text-white transition-colors">
        <span class="text-xs uppercase tracking-wider">Scroll to explore</span>
        <span class="w-px h-8" style="background: linear-gradient(to bottom, rgba(255,255,255,0.6), transparent); animation: float 2s ease-in-out infinite;"></span>
    </a>
</section>

{{-- ============ SHOP ============ --}}
<section id="shop" tabindex="-1" class="py-20 px-4 sm:px-6 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="section-label">The Collection</span>
            <h2 class="section-title mb-4">Shop Every Room</h2>
            <p class="text-gray-500">New pieces load automatically as you scroll — filter by room, search, or sort, and the catalog keeps growing without a single reload.</p>
        </div>

        @if($categories->isNotEmpty())
        <div class="rail-marquee-wrap mb-14" role="group" aria-label="Shop by room — auto-scrolling, pauses on hover or focus">
            <div class="rail-marquee" style="animation-duration: {{ max($categories->count() * 4, 12) }}s;">
                {{-- Rendered twice back-to-back so the loop is seamless; aria-hidden on the
                     repeat keeps screen readers from announcing every room a second time. --}}
                @for($pass = 0; $pass < 2; $pass++)
                    @foreach($categories as $category)
                    <a href="#shop"
                       onclick="Livewire.dispatch('shop-filter-category', { slug: '{{ $category->slug }}' })"
                       class="category-card card-hover group" style="width: 11rem;"
                       @if($pass === 1) aria-hidden="true" tabindex="-1" @endif>
                        @if($category->image_url)
                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}" loading="lazy">
                        @else
                            <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);">
                                <svg class="w-10 h-10 opacity-30 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                            </div>
                        @endif
                        <div class="category-card-overlay">
                            <h3 class="text-white font-semibold text-sm">{{ $category->name }}</h3>
                        </div>
                    </a>
                    @endforeach
                @endfor
            </div>
        </div>
        @endif

        <livewire:products.product-grid :show-toolbar="true" wire:key="onepage-shop-grid" />
    </div>
</section>

{{-- ============ SHOWROOM ============ --}}
<section id="showroom" tabindex="-1" class="showroom-bg py-24 px-4 sm:px-6 relative overflow-hidden"
         x-data="{ selected: {{ $featuredShowroomModel?->id ?? 'null' }} }">
    <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 2px 2px, rgba(212,168,83,0.5) 1px, transparent 0); background-size: 40px 40px;"></div>
    <div class="max-w-7xl mx-auto relative">
        <div class="grid lg:grid-cols-2 gap-12 items-start">
            <div>
                <span class="hero-badge mb-6 inline-flex">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                    Immersive Experience
                </span>
                <h2 class="section-title text-white mb-6">Walk Through Our<br><span style="color: var(--gold);">3D Showroom</span></h2>
                <p class="text-white/70 mb-6 leading-relaxed max-w-lg">Rotate, zoom and explore fully furnished rooms right here — see how a piece looks in a real space before it's in yours.</p>

                @if($showroomModels->isNotEmpty())
                <div class="rail mb-8">
                    @foreach($showroomModels as $model)
                    <button @click="selected = {{ $model->id }}"
                            class="text-left rounded-xl border-2 overflow-hidden transition-all flex gap-3 p-2.5"
                            style="width: 15rem;"
                            :style="selected === {{ $model->id }} ? 'border-color: var(--gold); background: rgba(212,168,83,0.1);' : 'border-color: rgba(255,255,255,0.1); background: rgba(255,255,255,0.04);'">
                        <div class="w-14 h-14 rounded-lg overflow-hidden flex-shrink-0 bg-white/10">
                            <img src="{{ $model->thumbnail_url }}" alt="{{ $model->name }}" class="w-full h-full object-cover">
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-semibold text-sm truncate text-white">{{ $model->name }}</h4>
                            @if($model->room_type)<p class="text-xs mt-0.5" style="color: var(--gold);">{{ $model->room_type }}</p>@endif
                        </div>
                    </button>
                    @endforeach
                </div>
                @endif

                <a href="{{ route('showroom') }}" class="btn-gold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/></svg>
                    Open Full Showroom
                </a>
            </div>

            <div class="rounded-2xl overflow-hidden bg-white" style="border: 1px solid rgba(212,168,83,0.2); aspect-ratio: 4/3;">
                @if($showroomModels->isNotEmpty())
                    @foreach($showroomModels as $model)
                    <div x-show="selected === {{ $model->id }}" x-cloak class="w-full h-full">
                        <model-viewer
                            src="{{ $model->model_url }}"
                            alt="{{ $model->name }}"
                            shadow-intensity="1"
                            camera-controls
                            auto-rotate
                            style="width: 100%; height: 100%; background: #faf5f0;">
                            <div slot="progress-bar" class="flex items-center justify-center w-full h-full" style="background: var(--cream);">
                                <div class="w-10 h-10 border-4 rounded-full animate-spin" style="border-color: var(--brand); border-top-color: transparent;"></div>
                            </div>
                        </model-viewer>
                    </div>
                    @endforeach
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center gap-4 text-center p-8" style="background: var(--cream);">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center animate-float" style="background: rgba(150,75,0,0.1);">
                            <svg class="w-8 h-8" style="color: var(--brand);" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/></svg>
                        </div>
                        <div>
                            <h3 class="font-semibold" style="color: var(--brand-dark);">Showroom coming soon</h3>
                            <p class="text-sm text-gray-400 mt-1">Our team is preparing 3D room models — check back shortly.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ============ ABOUT ============ --}}
<section id="about" tabindex="-1" class="py-20 px-4 sm:px-6 bg-white">
    <div class="max-w-6xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <h2 class="section-title mb-6">Furniture That Speaks Style</h2>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Ziego Furniture & Interiors brings world-class furniture and interior solutions to homes and offices across Nigeria. Over 1,000 offices and homes have trusted us to furnish spaces that are beautiful, functional and uniquely theirs.
                </p>
                <p class="text-gray-600 leading-relaxed mb-8">
                    From bulk corporate orders to bespoke residential pieces, every project gets the same craftsmanship and care. RC: 9093335.
                </p>
                <div class="flex flex-wrap gap-6 mb-8">
                    @foreach([
                        ['M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'Quality First'],
                        ['M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z', 'Customer Trust'],
                        ['M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9', 'National Reach'],
                    ] as [$path, $label])
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background: var(--brand-pale);">
                            <svg style="color: var(--brand); width: 1.125rem; height: 1.125rem;" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $path }}"/></svg>
                        </div>
                        <span class="text-sm font-medium" style="color: var(--brand-dark);">{{ $label }}</span>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('about') }}" class="text-sm font-semibold hover:underline" style="color: var(--brand);">Read our full story</a>
            </div>

            <div class="rounded-2xl overflow-hidden" style="aspect-ratio: 4/5;">
                <img src="/ceo2.png" alt="Founder & CEO, Ziego Furniture & Interiors" class="w-full h-full object-cover">
            </div>
        </div>
    </div>
</section>

{{-- ============ TESTIMONIALS ============ --}}
@if($testimonials->isNotEmpty())
<section id="testimonials" tabindex="-1" class="py-20 px-4 sm:px-6" style="background: var(--cream);">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <span class="section-label">Testimonials</span>
            <h2 class="section-title">What Our Clients Say</h2>
        </div>
        <div class="rail px-1">
            @foreach($testimonials as $testimonial)
            <div class="testimonial-card" style="width: 22rem;">
                <div class="flex gap-1 mb-4">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="w-4 h-4 {{ $i < $testimonial->rating ? '' : 'opacity-20' }}" style="color: var(--gold);" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-gray-600 text-sm leading-relaxed mb-6 relative z-10">{{ $testimonial->content }}</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0" style="background: var(--brand); color: white;">{{ substr($testimonial->name, 0, 1) }}</div>
                    <div>
                        <div class="font-semibold text-sm" style="color: var(--brand-dark);">{{ $testimonial->name }}</div>
                        @if($testimonial->company)<div class="text-xs text-gray-400">{{ $testimonial->company }}</div>@endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ CONTACT ============ --}}
<section id="contact" tabindex="-1" class="py-20 px-4 sm:px-6 bg-white">
    <div class="max-w-6xl mx-auto">
        <div class="text-center max-w-xl mx-auto mb-12">
            <span class="section-label">Get In Touch</span>
            <h2 class="section-title mb-4">Let's Furnish Your Space</h2>
            <p class="text-gray-500">Bulk orders, wholesale pricing or a custom piece — send a message and we'll reply shortly.</p>
        </div>

        <div class="grid lg:grid-cols-5 gap-10">
            <div class="lg:col-span-3 bg-white rounded-2xl border border-gray-100 shadow-sm p-8" id="onepage-contact-form">
                <form action="{{ route('contact.send') }}" method="POST" class="space-y-4"
                      x-data
                      x-on:submit="try { sessionStorage.setItem('ziego-onepage-scroll-anchor', 'contact') } catch (e) {}">
                    @csrf
                    <div style="position: absolute; left: -9999px;" aria-hidden="true">
                        <input type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Your Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="form-input" placeholder="John Doe">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="form-input" placeholder="john@company.com">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Subject *</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" required class="form-input" placeholder="Bulk furniture order inquiry">
                        @error('subject')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">Message *</label>
                        <textarea name="message" rows="4" required class="form-input" placeholder="Tell us about your furniture needs...">{{ old('message') }}</textarea>
                        @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="btn-primary w-full justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Send Message
                    </button>
                </form>
            </div>

            <div class="lg:col-span-2 space-y-4">
                <div class="flex gap-4 p-4 rounded-xl border border-gray-100 bg-white card-hover">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0" style="background: var(--brand-pale);">
                        <svg class="w-5 h-5" style="color: var(--brand);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-0.5">Phone / WhatsApp</div>
                        <a href="tel:09137652910" class="font-semibold hover:underline" style="color: var(--brand-dark);">09137652910</a>
                    </div>
                </div>
                <div class="flex gap-4 p-4 rounded-xl border border-gray-100 bg-white card-hover">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0" style="background: var(--brand-pale);">
                        <svg class="w-5 h-5" style="color: var(--brand);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-0.5">Email</div>
                        <a href="mailto:info@ziegofurniture.com" class="font-semibold hover:underline" style="color: var(--brand-dark);">info@ziegofurniture.com</a>
                    </div>
                </div>
                <div class="p-6 rounded-2xl" style="background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);">
                    <h3 class="text-white font-bold text-lg mb-3">Quick WhatsApp Order</h3>
                    <p class="text-white/70 text-sm mb-4">Prefer WhatsApp? Chat with us directly for bulk orders and custom requests.</p>
                    <a href="https://wa.me/2349137652910" target="_blank" class="flex items-center gap-2 bg-green-500 hover:bg-green-600 transition-colors text-white font-semibold py-3 px-5 rounded-lg text-sm w-fit">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Chat on WhatsApp
                    </a>
                </div>
                <div class="p-5 rounded-xl border border-gray-100 bg-white">
                    <h3 class="font-bold text-sm mb-3" style="color: var(--brand-dark);">Business Hours</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-gray-500">Monday – Friday</span><span class="font-medium">8:00 AM – 6:00 PM</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Saturday</span><span class="font-medium">9:00 AM – 4:00 PM</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Sunday</span><span class="text-gray-400">Closed</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</main>

@include('partials.site-footer')

@include('partials.whatsapp-float')

@if(session('success'))
<script>
    // If the contact form was submitted from within the page, land back at
    // the contact section instead of the very top after the redirect.
    document.addEventListener('DOMContentLoaded', () => {
        try {
            if (sessionStorage.getItem('ziego-onepage-scroll-anchor') === 'contact') {
                sessionStorage.removeItem('ziego-onepage-scroll-anchor');
                document.getElementById('contact')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        } catch (e) {}
    });
</script>
@endif

</body>
</html>

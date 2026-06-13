<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Ziego Furniture Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="antialiased" x-data="{ sidebarOpen: true, mobileOpen: false }">

{{-- Mobile overlay --}}
<div x-show="mobileOpen" x-cloak class="fixed inset-0 bg-black/50 z-30 lg:hidden" @click="mobileOpen = false"></div>

{{-- SIDEBAR --}}
<aside class="admin-sidebar" :class="{ 'open': mobileOpen }" style="display: flex; flex-direction: column;">
    {{-- Logo --}}
    <div class="p-5 border-b" style="border-color: rgba(255,255,255,0.08);">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center" style="background: var(--brand);">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M7 19H5V8H3V6h2V4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v2h2v2h-2v11h-2v-1H7v1z"/></svg>
            </div>
            <div>
                <div class="text-white font-bold text-sm">ZIEGO</div>
                <div class="text-xs" style="color: var(--gold); letter-spacing: 0.1em;">ADMIN PANEL</div>
            </div>
        </a>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 py-4 overflow-y-auto">
        {{-- Main --}}
        <div class="px-3 mb-1">
            <span class="text-xs font-semibold uppercase tracking-wider" style="color: rgba(255,255,255,0.3);">Main</span>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>

        {{-- Catalog --}}
        <div class="px-3 mt-5 mb-1">
            <span class="text-xs font-semibold uppercase tracking-wider" style="color: rgba(255,255,255,0.3);">Catalog</span>
        </div>
        <a href="{{ route('admin.products.index') }}" class="admin-nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            Products
        </a>
        <a href="{{ route('admin.categories.index') }}" class="admin-nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            Categories
        </a>

        {{-- Sales --}}
        <div class="px-3 mt-5 mb-1">
            <span class="text-xs font-semibold uppercase tracking-wider" style="color: rgba(255,255,255,0.3);">Sales</span>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="admin-nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Orders
        </a>
        <a href="{{ route('admin.invoices.index') }}" class="admin-nav-link {{ request()->routeIs('admin.invoices.*') ? 'active' : '' }}">
            <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Invoices
        </a>
        <a href="{{ route('admin.customers.index') }}" class="admin-nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
            <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Customers
        </a>

        {{-- Showroom --}}
        <div class="px-3 mt-5 mb-1">
            <span class="text-xs font-semibold uppercase tracking-wider" style="color: rgba(255,255,255,0.3);">Showroom</span>
        </div>
        <a href="{{ route('admin.showroom.index') }}" class="admin-nav-link {{ request()->routeIs('admin.showroom.*') ? 'active' : '' }}">
            <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/></svg>
            3D Showroom
        </a>

        {{-- ERM --}}
        <div class="px-3 mt-5 mb-1">
            <span class="text-xs font-semibold uppercase tracking-wider" style="color: rgba(255,255,255,0.3);">ERM System</span>
        </div>
        <a href="{{ route('admin.erm.employees.index') }}" class="admin-nav-link {{ request()->routeIs('admin.erm.employees.*') ? 'active' : '' }}">
            <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Employees
        </a>
        <a href="{{ route('admin.erm.suppliers.index') }}" class="admin-nav-link {{ request()->routeIs('admin.erm.suppliers.*') ? 'active' : '' }}">
            <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            Suppliers
        </a>
    </nav>

    {{-- Bottom --}}
    <div class="p-4 border-t" style="border-color: rgba(255,255,255,0.08);">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm" style="background: var(--brand);">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="min-w-0">
                <div class="text-white text-sm font-medium truncate">{{ auth()->user()->name }}</div>
                <div class="text-xs opacity-50 capitalize">{{ auth()->user()->role }}</div>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('home') }}" target="_blank" class="flex-1 text-center py-1.5 rounded-lg text-xs text-white/60 hover:text-white hover:bg-white/10 transition-colors">View Site</a>
            <form action="{{ route('logout') }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full py-1.5 rounded-lg text-xs text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-colors">Logout</button>
            </form>
        </div>
    </div>
</aside>

{{-- MAIN CONTENT --}}
<div class="admin-content">
    {{-- Topbar --}}
    <div class="admin-topbar">
        <div class="flex items-center gap-4">
            <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <h2 class="font-semibold text-gray-800">@yield('title', 'Dashboard')</h2>
        </div>
        <div class="flex items-center gap-3">
            @if(session('success') || session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)" class="max-w-xs">
                @if(session('success'))
                    <div class="alert-success text-xs px-3 py-2">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert-error text-xs px-3 py-2">{{ session('error') }}</div>
                @endif
            </div>
            @endif
            <span class="hidden md:flex items-center gap-2 text-sm text-gray-500">
                <div class="w-2 h-2 rounded-full bg-green-400"></div>
                Online
            </span>
        </div>
    </div>

    {{-- Page content --}}
    <main class="p-6">
        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>

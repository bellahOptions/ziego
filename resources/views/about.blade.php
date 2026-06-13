@extends('layouts.app')
@section('title', 'About Us — Ziego Furniture & Interiors')

@section('content')
<div class="pt-20">
    {{-- Hero --}}
    <div class="py-20 px-4 sm:px-6 relative overflow-hidden" style="background: linear-gradient(135deg, var(--brand-dark) 0%, #5A2D00 100%);">
        <div class="hero-pattern"></div>
        <div class="max-w-4xl mx-auto text-center relative">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4" style="font-family: 'Calistoga', serif;">About Ziego Furniture</h1>
            <p class="text-white/70 text-lg">A legacy of craftsmanship, quality, and style</p>
        </div>
    </div>

    {{-- Story --}}
    <section class="py-20 px-4 sm:px-6 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <span class="section-label">Our Story</span>
                    <h2 class="section-title mb-6">Furniture That <span style="color: var(--brand);">Speaks Style</span></h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Ziego Furniture & Interiors was founded with a singular mission: to bring world-class furniture and interior solutions to homes and offices across Nigeria. We believe that every space deserves to be beautiful, functional, and uniquely yours.
                    </p>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        With over 1,000 offices and homes transformed, we have established ourselves as a trusted name in premium furniture. Our RC Number 9093335 is a testament to our commitment to legitimate, professional business.
                    </p>
                    <p class="text-gray-600 leading-relaxed mb-8">
                        From bulk corporate orders to bespoke residential pieces, we handle every project with the same dedication to quality and customer satisfaction.
                    </p>
                    <div class="grid grid-cols-3 gap-6">
                        @foreach([['1,000+', 'Offices Served'], ['500+', 'Products'], ['100%', 'Nigeria Coverage']] as [$num, $label])
                        <div class="text-center">
                            <div class="text-3xl font-bold mb-1" style="color: var(--brand); font-family: 'Calistoga', serif;">{{ $num }}</div>
                            <div class="text-xs text-gray-400 uppercase tracking-wider">{{ $label }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="rounded-2xl p-8 flex items-center justify-center aspect-square" style="background: var(--brand);">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5V19a1 1 0 001 1h16a1 1 0 001-1v-8.5M3 10.5A2.5 2.5 0 015.5 8h13a2.5 2.5 0 012.5 2.5M3 10.5h18M7 8V6a2 2 0 012-2h6a2 2 0 012 2v2"/><path stroke-linecap="round" stroke-linejoin="round" d="M7 19v-5h10v5"/></svg>
                    </div>
                    <div class="rounded-2xl p-8 flex items-center justify-center aspect-square" style="background: var(--cream);">
                        <svg class="w-16 h-16" style="color: var(--brand);" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
                    </div>
                    <div class="rounded-2xl p-8 flex items-center justify-center aspect-square" style="background: var(--cream);">
                        <svg class="w-16 h-16" style="color: var(--brand);" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42"/></svg>
                    </div>
                    <div class="rounded-2xl p-8 flex items-center justify-center aspect-square" style="background: var(--brand);">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Values --}}
    <section class="py-20 px-4 sm:px-6" style="background: var(--cream);">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-14">
                <span class="section-label">Our Values</span>
                <h2 class="section-title">What Drives Us</h2>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center p-6 bg-white rounded-xl shadow-sm card-hover">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center mx-auto mb-4" style="background: var(--brand-pale);">
                        <svg class="w-7 h-7" style="color: var(--brand);" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <h3 class="font-bold mb-2" style="color: var(--brand-dark);">Quality First</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Every piece is crafted to the highest standards using premium materials.</p>
                </div>
                <div class="text-center p-6 bg-white rounded-xl shadow-sm card-hover">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center mx-auto mb-4" style="background: var(--brand-pale);">
                        <svg class="w-7 h-7" style="color: var(--brand);" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    </div>
                    <h3 class="font-bold mb-2" style="color: var(--brand-dark);">Customer Trust</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Building long-term relationships through transparency and reliability.</p>
                </div>
                <div class="text-center p-6 bg-white rounded-xl shadow-sm card-hover">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center mx-auto mb-4" style="background: var(--brand-pale);">
                        <svg class="w-7 h-7" style="color: var(--brand);" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/></svg>
                    </div>
                    <h3 class="font-bold mb-2" style="color: var(--brand-dark);">Innovation</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Constantly evolving our designs and services to meet modern needs.</p>
                </div>
                <div class="text-center p-6 bg-white rounded-xl shadow-sm card-hover">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center mx-auto mb-4" style="background: var(--brand-pale);">
                        <svg class="w-7 h-7" style="color: var(--brand);" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/></svg>
                    </div>
                    <h3 class="font-bold mb-2" style="color: var(--brand-dark);">National Reach</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Serving every corner of Nigeria with our nationwide delivery network.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-16 px-4 sm:px-6" style="background: var(--brand);">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-white mb-4" style="font-family: 'Calistoga', serif;">Ready to Work With Us?</h2>
            <p class="text-white/80 mb-8">RC: 9093335 | Call: 09137652910 | Nationwide Delivery</p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('contact') }}" class="btn-gold">Contact Us</a>
                <a href="{{ route('products.index') }}" class="btn-outline">Browse Products</a>
            </div>
        </div>
    </section>
</div>
@endsection

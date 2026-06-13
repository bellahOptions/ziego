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
                    @foreach(['🛋️', '🏢', '🎨', '🚚'] as $i => $emoji)
                    <div class="rounded-2xl p-8 flex items-center justify-center text-4xl aspect-square"
                         style="background: {{ $i % 2 === 0 ? 'var(--brand)' : 'var(--cream)' }}; {{ $i % 2 === 0 ? 'color: white;' : '' }}">
                        {{ $emoji }}
                    </div>
                    @endforeach
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
                @foreach([
                    ['⭐', 'Quality First', 'Every piece is crafted to the highest standards using premium materials.'],
                    ['🤝', 'Customer Trust', 'Building long-term relationships through transparency and reliability.'],
                    ['💡', 'Innovation', 'Constantly evolving our designs and services to meet modern needs.'],
                    ['🌍', 'National Reach', 'Serving every corner of Nigeria with our nationwide delivery network.'],
                ] as [$icon, $title, $desc])
                <div class="text-center p-6 bg-white rounded-xl shadow-sm card-hover">
                    <div class="text-4xl mb-4">{{ $icon }}</div>
                    <h3 class="font-bold mb-2" style="color: var(--brand-dark);">{{ $title }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $desc }}</p>
                </div>
                @endforeach
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

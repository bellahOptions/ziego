@extends('layouts.app')
@section('title', '3D Showroom — Ziego Furniture & Interiors')

@section('head')
<style>
    model-viewer {
        width: 100%;
        height: 100%;
        background: transparent;
        --poster-color: transparent;
    }
</style>
@endstack

@section('content')
<div class="pt-20">
    {{-- Hero --}}
    <div class="showroom-bg py-16 px-4 sm:px-6 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 2px 2px, rgba(212,168,83,0.5) 1px, transparent 0); background-size: 40px 40px;"></div>
        <div class="max-w-7xl mx-auto text-center relative">
            <span class="hero-badge mb-4 inline-flex">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                Virtual Experience
            </span>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4" style="font-family: 'Calistoga', serif;">
                Our <span style="color: var(--gold);">3D Showroom</span>
            </h1>
            <p class="text-white/70 max-w-2xl mx-auto">
                Experience our furniture collection in immersive 3D. Rotate, zoom, and explore each model before you buy.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12" x-data="{ selected: {{ $featured ? $featured->id : 'null' }} }">

        @if($models->isNotEmpty())
        <div class="grid lg:grid-cols-3 gap-8">
            {{-- 3D Viewer --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" style="aspect-ratio: 4/3;">
                    @foreach($models as $model)
                    <div x-show="selected === {{ $model->id }}" class="w-full h-full" x-cloak>
                        <model-viewer
                            src="{{ $model->model_url }}"
                            alt="{{ $model->name }}"
                            shadow-intensity="1"
                            camera-controls
                            auto-rotate
                            ar
                            style="width: 100%; height: 100%; background: #faf5f0;">
                            <div slot="progress-bar" class="flex items-center justify-center w-full h-full" style="background: var(--cream);">
                                <div class="text-center">
                                    <div class="w-12 h-12 border-4 rounded-full animate-spin mx-auto mb-4" style="border-color: var(--brand); border-top-color: transparent;"></div>
                                    <p class="text-sm text-gray-500">Loading 3D model...</p>
                                </div>
                            </div>
                        </model-viewer>
                    </div>
                    @endforeach

                    <div x-show="selected === null" class="w-full h-full flex items-center justify-center flex-col gap-4" style="background: var(--cream);">
                        <div class="w-20 h-20 rounded-2xl flex items-center justify-center animate-float" style="background: rgba(150,75,0,0.1);">
                            <svg class="w-10 h-10" style="color: var(--brand);" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/>
                            </svg>
                        </div>
                        <div class="text-center">
                            <h3 class="font-semibold" style="color: var(--brand-dark);">Select a model to view</h3>
                            <p class="text-sm text-gray-400 mt-1">Choose from the gallery on the right</p>
                        </div>
                    </div>
                </div>

                {{-- Controls help --}}
                <div class="flex flex-wrap gap-4 mt-4 text-xs text-gray-400">
                    <span class="flex items-center gap-1.5"><span class="w-5 h-5 bg-gray-100 rounded flex items-center justify-center font-bold text-gray-500">↺</span> Drag to rotate</span>
                    <span class="flex items-center gap-1.5"><span class="w-5 h-5 bg-gray-100 rounded flex items-center justify-center font-bold text-gray-500">⊕</span> Scroll to zoom</span>
                    <span class="flex items-center gap-1.5"><span class="w-5 h-5 bg-gray-100 rounded flex items-center justify-center font-bold text-gray-500">☁</span> AR compatible</span>
                </div>
            </div>

            {{-- Model list --}}
            <div>
                <h2 class="font-bold text-lg mb-4" style="color: var(--brand-dark); font-family: 'Calistoga', serif;">Select a Room</h2>
                <div class="space-y-3 max-h-[600px] overflow-y-auto pr-1">
                    @foreach($models as $model)
                    <button @click="selected = {{ $model->id }}"
                            class="w-full text-left rounded-xl border-2 overflow-hidden transition-all flex gap-3 p-3"
                            :class="selected === {{ $model->id }} ? 'border-orange-600 bg-orange-50' : 'border-gray-100 hover:border-orange-200 bg-white'">
                        <div class="w-20 h-16 rounded-lg overflow-hidden flex-shrink-0 bg-gray-100">
                            @if($model->thumbnail)
                                <img src="{{ $model->thumbnail_url }}" alt="{{ $model->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center" style="background: var(--brand-pale);">
                                    <svg class="w-8 h-8 opacity-40" style="color: var(--brand);" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-semibold text-sm truncate" style="color: var(--brand-dark);">{{ $model->name }}</h4>
                            @if($model->room_type)
                                <p class="text-xs mt-0.5" style="color: var(--brand);">{{ $model->room_type }}</p>
                            @endif
                            @if($model->description)
                                <p class="text-xs text-gray-400 mt-1 line-clamp-2">{{ $model->description }}</p>
                            @endif
                        </div>
                    </button>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-24">
            <div class="w-24 h-24 rounded-2xl flex items-center justify-center mx-auto mb-6 animate-float" style="background: var(--brand-pale);">
                <svg class="w-12 h-12" style="color: var(--brand);" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold mb-3" style="font-family: 'Calistoga', serif; color: var(--brand-dark);">Showroom Coming Soon</h2>
            <p class="text-gray-500 max-w-md mx-auto mb-8">Our 3D showroom is being set up. Our team will be uploading beautiful room models soon. Stay tuned!</p>
            <a href="{{ route('products.index') }}" class="btn-primary">Browse Products Instead</a>
        </div>
        @endif
    </div>
</div>
@endsection

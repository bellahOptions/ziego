@extends('layouts.app')
@section('title', $product->name . ' — Ziego Furniture')

@section('content')
<div class="pt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
        {{-- Breadcrumb --}}
        <nav class="text-sm mb-8 flex items-center gap-2 text-gray-400">
            <a href="{{ route('home') }}" class="hover:text-orange-800">Home</a>
            <span>›</span>
            <a href="{{ route('products.index') }}" class="hover:text-orange-800">Products</a>
            @if($product->category)
            <span>›</span>
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-orange-800">{{ $product->category->name }}</a>
            @endif
            <span>›</span>
            <span class="text-gray-700">{{ $product->name }}</span>
        </nav>

        <div class="grid lg:grid-cols-2 gap-12 mb-16">
            {{-- Images --}}
            <div x-data="{ active: 0 }">
                <div class="rounded-2xl overflow-hidden mb-4 border border-gray-100" style="aspect-ratio: 4/3; background: var(--cream);">
                    @if($product->images->isNotEmpty())
                        @foreach($product->images as $i => $img)
                        <img x-show="active === {{ $i }}" src="{{ $img->url }}" alt="{{ $img->alt ?? $product->name }}"
                             class="w-full h-full object-cover"
                             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        @endforeach
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-24 h-24 opacity-20" style="color: var(--brand);" fill="currentColor" viewBox="0 0 24 24"><path d="M7 19H5V8H3V6h2V4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v2h2v2h-2v11h-2v-1H7v1z"/></svg>
                        </div>
                    @endif
                </div>
                @if($product->images->count() > 1)
                <div class="flex gap-3">
                    @foreach($product->images as $i => $img)
                    <button @click="active = {{ $i }}"
                            class="w-20 h-16 rounded-lg overflow-hidden border-2 transition-all"
                            :class="active === {{ $i }} ? 'border-orange-600' : 'border-transparent hover:border-orange-200'">
                        <img src="{{ $img->url }}" alt="" class="w-full h-full object-cover">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Details --}}
            <div>
                @if($product->category)
                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-sm font-medium hover:underline" style="color: var(--brand);">
                    {{ $product->category->name }}
                </a>
                @endif

                <h1 class="text-3xl md:text-4xl font-bold mt-2 mb-4" style="font-family: 'Calistoga', serif; color: var(--brand-dark);">{{ $product->name }}</h1>

                {{-- Price --}}
                <div class="flex items-baseline gap-3 mb-6">
                    @if($product->sale_price)
                        <span class="text-3xl font-bold" style="color: var(--brand);">₦{{ number_format($product->sale_price) }}</span>
                        <span class="text-xl text-gray-400 line-through">₦{{ number_format($product->price) }}</span>
                        <span class="badge badge-cancelled text-sm">-{{ $product->discount_percentage }}% OFF</span>
                    @else
                        <span class="text-3xl font-bold" style="color: var(--brand);">₦{{ number_format($product->price) }}</span>
                    @endif
                </div>

                @if($product->short_description)
                <p class="text-gray-600 leading-relaxed mb-6">{{ $product->short_description }}</p>
                @endif

                {{-- Specs --}}
                <div class="grid grid-cols-2 gap-3 mb-6">
                    @if($product->material)
                    <div class="p-3 rounded-lg" style="background: var(--cream);">
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Material</div>
                        <div class="text-sm font-medium" style="color: var(--brand-dark);">{{ $product->material }}</div>
                    </div>
                    @endif
                    @if($product->dimensions)
                    <div class="p-3 rounded-lg" style="background: var(--cream);">
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Dimensions</div>
                        <div class="text-sm font-medium" style="color: var(--brand-dark);">{{ $product->dimensions }}</div>
                    </div>
                    @endif
                    @if($product->color)
                    <div class="p-3 rounded-lg" style="background: var(--cream);">
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Color</div>
                        <div class="text-sm font-medium" style="color: var(--brand-dark);">{{ $product->color }}</div>
                    </div>
                    @endif
                    @if($product->sku)
                    <div class="p-3 rounded-lg" style="background: var(--cream);">
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">SKU</div>
                        <div class="text-sm font-medium" style="color: var(--brand-dark);">{{ $product->sku }}</div>
                    </div>
                    @endif
                </div>

                {{-- Stock info --}}
                <div class="flex items-center gap-3 mb-6">
                    @if($product->stock > 0)
                        <span class="badge badge-active">✓ In Stock ({{ $product->stock }} available)</span>
                    @else
                        <span class="badge badge-cancelled">Out of Stock</span>
                    @endif
                    @if($product->is_wholesale)
                        <span class="badge badge-confirmed flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                            Wholesale Available
                        </span>
                    @endif
                </div>

                {{-- Wholesale note --}}
                @if($product->min_order_qty > 1)
                <div class="p-3 rounded-lg border mb-6 text-sm" style="background: var(--brand-pale); border-color: rgba(150,75,0,0.2);">
                    <strong style="color: var(--brand);">Minimum Order:</strong> {{ $product->min_order_qty }} units
                </div>
                @endif

                {{-- Add to cart --}}
                @if($product->stock > 0)
                <form action="{{ route('cart.add') }}" method="POST" class="flex gap-3 mb-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                        <button type="button" onclick="this.nextElementSibling.stepDown()" class="px-4 py-3 hover:bg-gray-50 text-gray-600 font-bold">−</button>
                        <input type="number" name="quantity" value="{{ $product->min_order_qty }}" min="{{ $product->min_order_qty }}" max="{{ $product->stock }}" class="w-14 text-center border-x border-gray-200 py-3 text-sm font-medium outline-none">
                        <button type="button" onclick="this.previousElementSibling.stepUp()" class="px-4 py-3 hover:bg-gray-50 text-gray-600 font-bold">+</button>
                    </div>
                    <button type="submit" class="btn-primary flex-1 justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Add to Cart
                    </button>
                </form>
                @endif

                {{-- WhatsApp order --}}
                <a href="https://wa.me/2349137652910?text=Hello%20Ziego%2C%20I%27m%20interested%20in%20{{ urlencode($product->name) }}" target="_blank"
                   class="flex items-center justify-center gap-2 w-full py-3 rounded-lg font-semibold text-sm transition-all hover:shadow-lg"
                   style="background: #25D366; color: white;">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Order via WhatsApp
                </a>
            </div>
        </div>

        {{-- Description Tabs --}}
        <div class="mb-16" x-data="{ tab: 'description' }">
            <div class="flex border-b border-gray-200 mb-6">
                <button @click="tab = 'description'" :class="tab === 'description' ? 'border-b-2 font-semibold' : 'text-gray-400'" class="px-6 py-3 text-sm transition-colors" style="border-color: var(--brand); color: var(--brand-dark);">Description</button>
                @if($product->dimensions || $product->material || $product->weight)
                <button @click="tab = 'specs'" :class="tab === 'specs' ? 'border-b-2 font-semibold' : 'text-gray-400'" class="px-6 py-3 text-sm transition-colors" style="border-color: var(--brand); color: var(--brand-dark);">Specifications</button>
                @endif
            </div>
            <div x-show="tab === 'description'" class="prose max-w-none text-gray-600 leading-relaxed">
                {!! nl2br(e($product->description ?? 'No detailed description available.')) !!}
            </div>
            <div x-show="tab === 'specs'" x-cloak>
                <table class="w-full text-sm">
                    @foreach(['Material' => $product->material, 'Dimensions' => $product->dimensions, 'Weight' => $product->weight, 'Color' => $product->color, 'SKU' => $product->sku] as $key => $val)
                        @if($val)
                        <tr class="border-b border-gray-100">
                            <td class="py-3 pr-8 font-medium text-gray-500 w-40">{{ $key }}</td>
                            <td class="py-3 text-gray-800">{{ $val }}</td>
                        </tr>
                        @endif
                    @endforeach
                </table>
            </div>
        </div>

        {{-- Related --}}
        @if($related->isNotEmpty())
        <div>
            <h2 class="text-2xl font-bold mb-8" style="font-family: 'Calistoga', serif; color: var(--brand-dark);">You May Also Like</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @foreach($related as $item)
                <div class="product-card">
                    <div class="overflow-hidden" style="aspect-ratio: 4/3;">
                        <a href="{{ route('products.show', $item->slug) }}">
                            @if($item->primaryImage)
                                <img src="{{ $item->primaryImage->url }}" alt="{{ $item->name }}" class="product-card-img" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center" style="background: var(--cream);">
                                    <svg class="w-10 h-10 opacity-20" style="color: var(--brand);" fill="currentColor" viewBox="0 0 24 24"><path d="M7 19H5V8H3V6h2V4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v2h2v2h-2v11h-2v-1H7v1z"/></svg>
                                </div>
                            @endif
                        </a>
                    </div>
                    <div class="p-3">
                        <a href="{{ route('products.show', $item->slug) }}" class="text-sm font-semibold hover:text-orange-800 transition-colors" style="color: var(--brand-dark);">{{ $item->name }}</a>
                        <div class="font-bold mt-1 text-sm" style="color: var(--brand);">₦{{ number_format($item->current_price) }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

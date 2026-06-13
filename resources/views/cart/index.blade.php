@extends('layouts.app')
@section('title', 'Shopping Cart — Ziego Furniture')

@section('content')
<div class="pt-20">
    <div class="py-10 px-4 sm:px-6" style="background: var(--cream);">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-bold" style="font-family: 'Calistoga', serif; color: var(--brand-dark);">Shopping Cart</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
        @if($cart->items->isEmpty())
        <div class="text-center py-20">
            <div class="w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6" style="background: var(--cream);">
                <svg class="w-12 h-12 opacity-30" style="color: var(--brand);" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
            </div>
            <h2 class="text-2xl font-bold mb-3" style="font-family: 'Calistoga', serif; color: var(--brand-dark);">Your cart is empty</h2>
            <p class="text-gray-400 mb-8">Browse our products and add items to your cart.</p>
            <a href="{{ route('products.index') }}" class="btn-primary">Browse Products</a>
        </div>
        @else
        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Cart Items --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-gray-100">
                        <h2 class="font-bold text-lg" style="color: var(--brand-dark);">{{ $cart->count }} item{{ $cart->count !== 1 ? 's' : '' }} in cart</h2>
                    </div>

                    @foreach($cart->items as $item)
                    <div class="flex gap-4 p-5 border-b border-gray-50 last:border-0">
                        <div class="w-24 h-20 rounded-lg overflow-hidden flex-shrink-0 bg-gray-50">
                            @if($item->product->primaryImage)
                                <img src="{{ `$item->product->primaryImage->url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-8 h-8 opacity-20" style="color: var(--brand);" fill="currentColor" viewBox="0 0 24 24"><path d="M7 19H5V8H3V6h2V4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v2h2v2h-2v11h-2v-1H7v1z"/></svg>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <a href="{{ route('products.show', $item->product->slug) }}" class="font-semibold text-sm hover:text-orange-800 transition-colors" style="color: var(--brand-dark);">
                                {{ $item->product->name }}
                            </a>
                            @if($item->product->category)
                            <p class="text-xs text-gray-400 mt-0.5">{{ $item->product->category->name }}</p>
                            @endif
                            <div class="font-bold mt-2 text-sm" style="color: var(--brand);">₦{{ number_format($item->product->current_price) }}</div>

                            <div class="flex items-center gap-3 mt-3">
                                <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-1">
                                    @csrf @method('PATCH')
                                    <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                                        <button type="button" onclick="let i=this.nextElementSibling; if(i.value>i.min){i.value=parseInt(i.value)-1; this.closest('form').submit()}" class="px-2.5 py-1.5 hover:bg-gray-50 text-gray-500 text-sm">−</button>
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="w-10 text-center border-x border-gray-200 py-1.5 text-sm outline-none">
                                        <button type="button" onclick="let i=this.previousElementSibling; if(i.value<i.max){i.value=parseInt(i.value)+1; this.closest('form').submit()}" class="px-2.5 py-1.5 hover:bg-gray-50 text-gray-500 text-sm">+</button>
                                    </div>
                                </form>

                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-red-400 hover:text-red-600 transition-colors">Remove</button>
                                </form>
                            </div>
                        </div>

                        <div class="text-right flex-shrink-0">
                            <div class="font-bold" style="color: var(--brand-dark);">₦{{ number_format($item->product->current_price * $item->quantity) }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Order Summary --}}
            <div>
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 sticky top-24">
                    <h2 class="font-bold text-lg mb-6" style="color: var(--brand-dark);">Order Summary</h2>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Subtotal</span>
                            <span class="font-medium">₦{{ number_format($cart->total) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Shipping</span>
                            <span class="text-green-600 font-medium">Calculated at checkout</span>
                        </div>
                        <div class="border-t border-gray-100 pt-3 flex justify-between font-bold text-lg">
                            <span>Total</span>
                            <span style="color: var(--brand);">₦{{ number_format($cart->total) }}</span>
                        </div>
                    </div>

                    @auth
                        <a href="{{ route('checkout.index') }}" class="btn-primary w-full justify-center mb-3">
                            Proceed to Checkout
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary w-full justify-center mb-3">Login to Checkout</a>
                    @endauth

                    <a href="{{ route('products.index') }}" class="text-center block text-sm text-gray-400 hover:text-gray-600 transition-colors">
                        ← Continue Shopping
                    </a>

                    <div class="mt-6 p-4 rounded-lg text-center" style="background: var(--cream);">
                        <p class="text-xs text-gray-500">For bulk orders & wholesale pricing</p>
                        <a href="https://wa.me/2349137652910" target="_blank" class="text-sm font-semibold hover:underline" style="color: var(--brand);">
                            Contact us on WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Checkout — Ziego Furniture')

@section('content')
<div class="pt-20">
    <div class="py-10 px-4 sm:px-6" style="background: var(--cream);">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-bold" style="font-family: 'Calistoga', serif; color: var(--brand-dark);">Checkout</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="grid lg:grid-cols-3 gap-8">
                {{-- Shipping Info --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
                        <h2 class="font-bold text-lg mb-6" style="color: var(--brand-dark);">Shipping Information</h2>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}" required class="form-input" placeholder="Enter full name">
                                @error('shipping_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="form-label">Phone Number *</label>
                                <input type="text" name="shipping_phone" value="{{ old('shipping_phone', auth()->user()->phone) }}" required class="form-input" placeholder="09137652910">
                                @error('shipping_phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="form-label">Email Address</label>
                                <input type="email" name="shipping_email" value="{{ old('shipping_email', auth()->user()->email) }}" class="form-input" placeholder="email@example.com">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="form-label">Delivery Address *</label>
                                <textarea name="shipping_address" required rows="3" class="form-input" placeholder="House number, street name, area...">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                                @error('shipping_address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="form-label">City</label>
                                <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" class="form-input" placeholder="Lagos">
                            </div>
                            <div>
                                <label class="form-label">State</label>
                                <select name="shipping_state" class="form-input">
                                    <option value="">Select State</option>
                                    @foreach(['Abia','Adamawa','Akwa Ibom','Anambra','Bauchi','Bayelsa','Benue','Borno','Cross River','Delta','Ebonyi','Edo','Ekiti','Enugu','FCT','Gombe','Imo','Jigawa','Kaduna','Kano','Katsina','Kebbi','Kogi','Kwara','Lagos','Nasarawa','Niger','Ogun','Ondo','Osun','Oyo','Plateau','Rivers','Sokoto','Taraba','Yobe','Zamfara'] as $state)
                                        <option value="{{ $state }}" {{ old('shipping_state') === $state ? 'selected' : '' }}>{{ $state }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="form-label">Order Notes (Optional)</label>
                                <textarea name="notes" rows="2" class="form-input" placeholder="Any special delivery instructions?">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                        <h2 class="font-bold text-lg mb-4" style="color: var(--brand-dark);">Payment Method</h2>
                        <div class="p-4 rounded-lg border-2 flex items-center gap-3" style="border-color: var(--brand); background: var(--brand-pale);">
                            <div class="w-5 h-5 rounded-full flex-shrink-0" style="background: var(--brand);"></div>
                            <div>
                                <div class="font-semibold text-sm" style="color: var(--brand-dark);">Pay on Delivery / Bank Transfer</div>
                                <div class="text-xs text-gray-500 mt-0.5">Our team will confirm your order and provide payment details</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div>
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 sticky top-24">
                        <h2 class="font-bold text-lg mb-5" style="color: var(--brand-dark);">Order Summary</h2>

                        <div class="space-y-3 mb-5">
                            @foreach($cart->items as $item)
                            <div class="flex gap-3">
                                <div class="w-14 h-12 rounded-lg overflow-hidden flex-shrink-0 bg-gray-50">
                                    @if($item->product->primaryImage)
                                        <img src="{{ $item->product->primaryImage->url }}" alt="" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-medium truncate" style="color: var(--brand-dark);">{{ $item->product->name }}</p>
                                    <p class="text-xs text-gray-400">Qty: {{ $item->quantity }}</p>
                                </div>
                                <div class="text-sm font-semibold flex-shrink-0" style="color: var(--brand);">₦{{ number_format($item->product->current_price * $item->quantity) }}</div>
                            </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-100 pt-4 space-y-2 mb-5">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Subtotal</span>
                                <span class="font-medium">₦{{ number_format($cart->total) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Shipping</span>
                                <span class="text-green-600 font-medium">TBD</span>
                            </div>
                            <div class="border-t border-gray-100 pt-2 flex justify-between font-bold">
                                <span>Total</span>
                                <span style="color: var(--brand);">₦{{ number_format($cart->total) }}</span>
                            </div>
                        </div>

                        <button type="submit" class="btn-primary w-full justify-center">
                            Place Order
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

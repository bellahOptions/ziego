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
        <livewire:cart.cart-manager />
    </div>
</div>
@endsection

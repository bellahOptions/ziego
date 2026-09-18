<div>
    @if($similar->isNotEmpty())
    <div class="mb-16">
        <div class="flex items-center justify-between mb-2">
            <h2 class="text-2xl font-bold" style="font-family: 'Calistoga', serif; color: var(--brand-dark);">Smart Compare</h2>
        </div>
        <p class="text-sm text-gray-400 mb-8">We matched these products to <strong>{{ $product->name }}</strong> by category, material, color and price.</p>

        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse" style="min-width: 640px;">
                <thead>
                    <tr>
                        <th class="text-left p-3 w-40"></th>
                        <th class="p-3 text-center">
                            <div class="w-20 h-20 rounded-lg overflow-hidden mx-auto mb-2 border-2" style="border-color: var(--brand);">
                                @if($product->primaryImage)
                                    <img src="{{ $product->primaryImage->url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center" style="background: var(--cream);"></div>
                                @endif
                            </div>
                            <div class="text-xs font-semibold" style="color: var(--brand-dark);">{{ $product->name }}</div>
                            <span class="badge badge-active mt-1 inline-block">This item</span>
                        </th>
                        @foreach($similar as $item)
                        <th class="p-3 text-center">
                            <a href="{{ route('products.show', $item->slug) }}" class="block">
                                <div class="w-20 h-20 rounded-lg overflow-hidden mx-auto mb-2 border border-gray-100">
                                    @if($item->primaryImage)
                                        <img src="{{ $item->primaryImage->url }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center" style="background: var(--cream);"></div>
                                    @endif
                                </div>
                                <div class="text-xs font-semibold hover:underline" style="color: var(--brand-dark);">{{ $item->name }}</div>
                            </a>
                            <span class="badge badge-confirmed mt-1 inline-block">{{ $item->match_score }}% match</span>
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($specRows['rows'] as $label => $accessor)
                    <tr class="border-t border-gray-100">
                        <td class="p-3 font-medium text-gray-500">{{ $label }}</td>
                        <td class="p-3 text-center {{ $label === 'Price' && (float) $product->current_price === (float) $specRows['lowestPrice'] ? 'font-bold' : '' }}" style="{{ $label === 'Price' && (float) $product->current_price === (float) $specRows['lowestPrice'] ? 'color: var(--brand);' : '' }}">
                            {{ $accessor($product) }}
                            @if($label === 'Price' && (float) $product->current_price === (float) $specRows['lowestPrice'])
                                <svg class="w-3.5 h-3.5 inline-block -mt-0.5" style="color: var(--brand);" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            @endif
                        </td>
                        @foreach($similar as $item)
                        <td class="p-3 text-center {{ $label === 'Price' && (float) $item->current_price === (float) $specRows['lowestPrice'] ? 'font-bold' : '' }}" style="{{ $label === 'Price' && (float) $item->current_price === (float) $specRows['lowestPrice'] ? 'color: var(--brand);' : '' }}">
                            {{ $accessor($item) }}
                            @if($label === 'Price' && (float) $item->current_price === (float) $specRows['lowestPrice'])
                                <svg class="w-3.5 h-3.5 inline-block -mt-0.5" style="color: var(--brand);" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

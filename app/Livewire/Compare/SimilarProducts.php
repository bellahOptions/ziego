<?php

namespace App\Livewire\Compare;

use App\Models\Product;
use Illuminate\Support\Collection;
use Livewire\Component;

class SimilarProducts extends Component
{
    public Product $product;

    public function mount(Product $product): void
    {
        $this->product = $product;
    }

    public function render()
    {
        $similar = $this->product->similarProducts(3);

        return view('livewire.compare.similar-products', [
            'similar' => $similar,
            'specRows' => $this->buildSpecRows($similar),
        ]);
    }

    private function buildSpecRows(Collection $similar): array
    {
        $rows = [
            'Price'      => fn ($p) => '₦' . number_format($p->current_price),
            'Category'   => fn ($p) => $p->category->name ?? '—',
            'Material'   => fn ($p) => $p->material ?: '—',
            'Color'      => fn ($p) => $p->color ?: '—',
            'Dimensions' => fn ($p) => $p->dimensions ?: '—',
            'Stock'      => fn ($p) => $p->stock > 0 ? "{$p->stock} available" : 'Out of stock',
        ];

        $all = $similar->prepend($this->product);

        // Only include price in the "best" comparison since it's the one objectively rankable field.
        $lowestPrice = $all->min(fn ($p) => (float) $p->current_price);

        return [
            'rows' => $rows,
            'lowestPrice' => $lowestPrice,
        ];
    }
}

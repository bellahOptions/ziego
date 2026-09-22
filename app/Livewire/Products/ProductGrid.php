<?php

namespace App\Livewire\Products;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class ProductGrid extends Component
{
    #[Url(as: 'category', history: true)]
    public string $category = '';

    #[Url(as: 'search', history: true)]
    public string $search = '';

    #[Url(as: 'min_price', history: true)]
    public ?string $minPrice = null;

    #[Url(as: 'max_price', history: true)]
    public ?string $maxPrice = null;

    #[Url(as: 'sort', history: true)]
    public string $sort = '';

    public int $perPage = 12;

    /**
     * When true, renders an inline category/search/sort toolbar above the grid
     * so the component works as a self-contained, reactive shop section (used
     * on the onepage). Default false keeps existing pages (e.g. /products,
     * which has its own external sidebar filters) visually unchanged.
     */
    public bool $showToolbar = false;

    #[On('shop-filter-category')]
    public function filterCategory(string $slug): void
    {
        $this->category = $this->category === $slug ? '' : $slug;
        $this->perPage = 12;
    }

    public function updatedCategory(): void
    {
        $this->perPage = 12;
    }

    public function updatedSearch(): void
    {
        $this->perPage = 12;
    }

    public function updatedSort(): void
    {
        $this->perPage = 12;
    }

    public function applyPriceFilter(): void
    {
        $this->perPage = 12;
    }

    public function clearFilters(): void
    {
        $this->reset(['category', 'search', 'minPrice', 'maxPrice', 'sort']);
        $this->perPage = 12;
    }

    public function loadMore(): void
    {
        $this->perPage += 12;
    }

    private function baseQuery()
    {
        $query = Product::with(['primaryImage', 'category'])->where('status', 'active');

        if ($this->category !== '') {
            $query->whereHas('category', fn ($q) => $q->where('slug', $this->category));
        }

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%");
            });
        }

        if ($this->minPrice !== null && $this->minPrice !== '') {
            $query->where('price', '>=', $this->minPrice);
        }

        if ($this->maxPrice !== null && $this->maxPrice !== '') {
            $query->where('price', '<=', $this->maxPrice);
        }

        match ($this->sort) {
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'popular'    => $query->orderByDesc('views'),
            default      => $query->latest(),
        };

        return $query;
    }

    public function render()
    {
        $total = $this->baseQuery()->count();
        $products = $this->baseQuery()->take($this->perPage)->get();

        return view('livewire.products.product-grid', [
            'products'   => $products,
            'total'      => $total,
            'hasMore'    => $this->perPage < $total,
            'categories' => $this->showToolbar
                ? Category::where('is_active', true)->orderBy('sort_order')->get()
                : collect(),
        ]);
    }
}

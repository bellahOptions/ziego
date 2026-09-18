<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'slug', 'short_description', 'description',
        'price', 'sale_price', 'stock', 'sku', 'material', 'dimensions',
        'weight', 'color', 'featured', 'is_wholesale', 'min_order_qty', 'status', 'views',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'featured' => 'boolean',
        'is_wholesale' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLog::class);
    }

    public function wishlistedBy()
    {
        return $this->belongsToMany(User::class, 'wishlists')->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Score-ranked "similar products" for the compare panel: same category,
     * shared material/color, and price proximity all weigh into the score.
     */
    public function similarProducts(int $limit = 3)
    {
        $candidates = static::active()
            ->with(['images', 'category'])
            ->where('id', '!=', $this->id)
            ->where('category_id', $this->category_id)
            ->get();

        if ($candidates->count() < $limit) {
            $extra = static::active()
                ->with(['images', 'category'])
                ->where('id', '!=', $this->id)
                ->where('category_id', '!=', $this->category_id)
                ->whereNotIn('id', $candidates->pluck('id'))
                ->get();
            $candidates = $candidates->concat($extra);
        }

        $basePrice = (float) $this->current_price;

        return $candidates
            ->map(function ($product) use ($basePrice) {
                $score = 0;

                if ($product->category_id === $this->category_id) {
                    $score += 35;
                }
                if ($product->material && $this->material && strcasecmp($product->material, $this->material) === 0) {
                    $score += 25;
                }
                if ($product->color && $this->color && strcasecmp($product->color, $this->color) === 0) {
                    $score += 15;
                }
                if ($basePrice > 0) {
                    $priceDiff = abs((float) $product->current_price - $basePrice) / $basePrice;
                    $score += max(0, 20 * (1 - min($priceDiff, 1)));
                }
                if ($product->is_wholesale === $this->is_wholesale) {
                    $score += 5;
                }

                $product->match_score = (int) round($score);

                return $product;
            })
            ->sortByDesc('match_score')
            ->take($limit)
            ->values();
    }

    public function getCurrentPriceAttribute(): float
    {
        return $this->sale_price ?? $this->price;
    }

    public function getDiscountPercentageAttribute(): int
    {
        if (!$this->sale_price) return 0;
        return (int) round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}

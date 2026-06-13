<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShowroomModel extends Model
{
    protected $fillable = [
        'name', 'description', 'model_path', 'thumbnail',
        'room_type', 'is_active', 'is_featured', 'sort_order',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function getModelUrlAttribute(): string
    {
        return asset('storage/' . $this->model_path);
    }

    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : asset('images/showroom-placeholder.jpg');
    }
}

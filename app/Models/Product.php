<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'brand_id',
        'price',
        'sale_price',
        'stock',
        'is_active',
        'description',
        'specifications',
    ];

    protected $appends = [
        'final_price',
        'main_image_url',
    ];

    protected function casts(): array
    {
        return [
            'price'          => 'decimal:2',
            'sale_price'     => 'decimal:2',
            'stock'          => 'integer',
            'is_active'      => 'boolean',
            'specifications' => 'array',
        ];
    }

    public function scopeFilter($query, $filters)
    {
        return $query
            ->when(
                $filters['search'] ?? null,
                fn($q, $search) =>
                $q->whereAny(['name', 'slug'], 'like', "%$search%")
            )
            ->when(
                $filters['brand_id'] ?? null,
                fn($q, $brandId) =>
                $q->where('brand_id', $brandId)
            )
            ->when(
                $filters['stock'] ?? null,
                fn($q, $stock) =>
                match ($stock) {
                    'in_stock'     => $q->where('stock', '>', 10),
                    'low_stock'    => $q->whereBetween('stock', [1, 10]),
                    'out_of_stock' => $q->where('stock', 0),
                    default        => $q,
                }
            )
            ->when(
                isset($filters['is_active']),
                fn($q) =>
                $q->where('is_active', $filters['is_active'])
            );
    }

    public function getFinalPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    public function getMainImageUrlAttribute()
    {
        return optional($this->mainImage)->url;
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function mainImage()
    {
        return $this->hasOne(Image::class)->where('is_main', true);
    }
}

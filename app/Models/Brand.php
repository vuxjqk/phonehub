<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'logo',
    ];

    protected $appends = ['logo_url'];

    public function scopeFilter($query, $search)
    {
        return $query
            ->when(
                $search,
                fn($q) =>
                $q->whereAny(['name', 'slug'], 'like', "%$search%")
            );
    }

    public function getLogoUrlAttribute()
    {
        return $this->logo
            ? Storage::url($this->logo)
            : null;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

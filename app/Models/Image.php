<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = [
        'product_id',
        'path',
        'is_main',
    ];

    protected $appends = ['url'];

    protected function casts(): array
    {
        return [
            'is_main' => 'boolean',
        ];
    }

    public function getUrlAttribute()
    {
        return $this->path
            ? Storage::url($this->path)
            : null;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'uuid',
        'name',
        'slug',
        'price',
        'description',
        'is_new',
        'is_online',
        'large_description',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function getSmallImageAttribute()
    {
        if ($this->images)
            return config('app.url') . "/storage/images/products/{$this->uuid}/{$this->images[0]->small}";
    }

    public function getMediumImageAttribute()
    {
        if ($this->images)
            return config('app.url') . "/storage/images/products/{$this->uuid}/{$this->images[0]->medium}";
    }

    public function getThumbImageAttribute()
    {
        if ($this->images)
            return config('app.url') . "/storage/images/products/{$this->uuid}/{$this->images[0]->thumb}";
    }

    public function getImageAttribute()
    {
        if ($this->images)
            return config('app.url') . "/storage/images/products/{$this->uuid}/{$this->images[0]->name}";
    }

    protected $appends = [
        'small_image',
        'thumb_image',
        'medium_image',
        'image',
    ];
}

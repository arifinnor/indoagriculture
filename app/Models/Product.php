<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'description',
        'name_de',
        'description_de',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public $incrementing = true;

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'product_attributes')->withPivot('value');
    }

    public function productAttributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function thumbnail(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('type', 'thumbnail');
    }

    public function cover(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('type', 'background');
    }
}

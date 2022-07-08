<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'attribute_id',
        'value',
    ];

    public function products(): BelongsTo
    {
        return $this->BelongsTo(Product::class);
    }

    public function attributes(): BelongsTo
    {
        return $this->BelongsTo(Attribute::class);
    }
}

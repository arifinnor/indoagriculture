<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    public const TYPE_BACKGROUND = 'background';
    public const TYPE_THUMBNAIL = 'thumbnail';

    protected $fillable = [
        'product_id',
        'title',
        'url',
        'type',
    ];

    protected $casts = [
        'type' => 'string'
    ];

    public static function getImageType(): array
    {
        return [
            self::TYPE_BACKGROUND,
            self::TYPE_THUMBNAIL,
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

<?php

namespace App\Enums;

enum Category: string
{
    case PLANTING_MEDIA = 'planting_media';
    case SPICES = 'spices';
    case TROPICAL_FRUIT = 'tropical_fruit';

    public static function all(): array
    {
        return collect(Category::cases())->map(fn (Category $category) => $category->value)->toArray();
    }

    public static function findCase(string $case): ?Category
    {
        return Category::tryFrom($case);
    }


    public static function transform(): array
    {
        return [
            self::PLANTING_MEDIA->value => 'Planting Media',
            self::SPICES->value => 'Spices',
            self::TROPICAL_FRUIT->value => 'Tropical Fruit',
        ];
    }

    public static function list(): array
    {
        return collect(Category::cases())->mapWithKeys(fn (Category $category) => [$category->name => $category->value])->toArray();
    }
}

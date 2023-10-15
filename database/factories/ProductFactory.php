<?php

namespace Database\Factories;

use App\Enums\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'category' => Category::TROPICAL_FRUIT->value,
            'description' => $this->faker->paragraph(10),
            'name_de' => $this->faker->word,
            'description_de' => $this->faker->paragraph(10),
            'is_active' => true,
        ];
    }
}

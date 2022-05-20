<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory(4)->create();
        $faker = \Faker\Factory::create();

        foreach (Product::cursor() as $product) {
            foreach (Attribute::cursor() as $attr) {
                $product->productAttributes()->create(['attribute_id' => $attr->id]);
            }


            foreach (ProductImage::getImageType() as $type) {
                $product->productImages()->create([
                    'title' => $faker->word,
                    'url' => $faker->imageUrl,
                    'type' => $type,
                ]);
            }
        }
    }
}

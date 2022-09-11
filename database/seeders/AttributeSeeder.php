<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\ProductAttribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Attribute::factory(11)->create();

        $attributes = [
            'Grade', 'Origin', 'Size', 'Age', 'Container Capacity', 'Stems', 'Inferior Cloves',
            'Admixture', 'Moisture', 'Skin Color', 'Flesh Color', 'Packaging',
        ];

        foreach ($attributes as $attr) {
            Attribute::create([
                'name' => $attr
            ]);
        }
    }
}

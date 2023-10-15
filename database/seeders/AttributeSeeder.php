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
        $attributes = [
            [
                'name' => 'Grade',
                'language' => 'en'
            ],
            [
                'name' => 'Origin',
                'language' => 'en'
            ],
            [
                'name' => 'Size',
                'language' => 'en'
            ],
            [
                'name' => 'Age',
                'language' => 'en'
            ],
            [
                'name' => 'Container Capacity',
                'language' => 'en'
            ],
            [
                'name' => 'Stems',
                'language' => 'en'
            ],
            [
                'name' => 'Inferior Cloves',
                'language' => 'en'
            ],
            [
                'name' => 'Admixture',
                'language' => 'en'
            ],
            [
                'name' => 'Moisture',
                'language' => 'en'
            ],
            [
                'name' => 'Skin Color',
                'language' => 'en'
            ],
            [
                'name' => 'Flesh Color',
                'language' => 'en'
            ],
            [
                'name' => 'Packaging',
                'language' => 'en'
            ],
            [
                'name' => 'Grade',
                'language' => 'de'
            ],
            [
                'name' => 'Herkunft',
                'language' => 'de'
            ],
            [
                'name' => 'Größe',
                'language' => 'de'
            ],
            [
                'name' => 'Alter',
                'language' => 'de'
            ],
            [
                'name' => 'Containerkapazität',
                'language' => 'de'
            ],
            [
                'name' => 'Stämme',
                'language' => 'de'
            ],
            [
                'name' => 'Inferiore Gewürznelken',
                'language' => 'de'
            ],
            [
                'name' => 'Beimischung',
                'language' => 'de'
            ],
            [
                'name' => 'Feuchtigkeit',
                'language' => 'de'
            ],
            [
                'name' => 'Hautfarbe',
                'language' => 'de'
            ],
            [
                'name' => 'Fleischfarbe',
                'language' => 'de'
            ],
            [
                'name' => 'Verpackung',
                'language' => 'de'
            ],

        ];

        foreach ($attributes as $attr) {
            Attribute::create($attr);
        }
    }
}

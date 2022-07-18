<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // \App\Models\User::factory()->create(),
            UserSeeder::class,
            AttributeSeeder::class,
            // ProductSeeder::class,
        ]);
    }
}

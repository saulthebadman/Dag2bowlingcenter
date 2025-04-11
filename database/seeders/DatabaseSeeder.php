<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SpellenTableSeeder::class,
            PersonenTableSeeder::class,
            ReserveringenTableSeeder::class,
            UitslagOverzichtTableSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonenTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('persoon')->insert([
            ['naam' => 'Mazin Jamil', 'created_at' => now(), 'updated_at' => now()],
            ['naam' => 'John Doe', 'created_at' => now(), 'updated_at' => now()],
            ['naam' => 'Jane Smith', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpellenTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('spellen')->insert([
            ['naam' => 'Bowling Game 1', 'created_at' => now(), 'updated_at' => now()],
            ['naam' => 'Bowling Game 2', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

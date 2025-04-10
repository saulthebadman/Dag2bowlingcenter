<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaanSeeder extends Seeder
{
    public function run()
    {
        DB::table('banen')->insert([
            ['nummer' => '1', 'is_kinderbaan' => false],
            ['nummer' => '2', 'is_kinderbaan' => false],
            ['nummer' => '3', 'is_kinderbaan' => true],
            ['nummer' => '4', 'is_kinderbaan' => true],
            ['nummer' => '5', 'is_kinderbaan' => false],
            ['nummer' => '6', 'is_kinderbaan' => false],
        ]);
    }
}

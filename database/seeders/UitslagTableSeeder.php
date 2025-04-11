<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UitslagTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('uitslag')->insert([
            ['spel_id' => 1, 'persoon_id' => 1, 'aantal_punten' => 150, 'created_at' => now(), 'updated_at' => now()],
            ['spel_id' => 1, 'persoon_id' => 2, 'aantal_punten' => 200, 'created_at' => now(), 'updated_at' => now()],
            ['spel_id' => 2, 'persoon_id' => 3, 'aantal_punten' => 180, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

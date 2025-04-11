<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReserveringenTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('reservering')->insert([
            [
                'persoon_id' => 1,
                'datum' => '2023-10-01',
                'aantal_uren' => 2,
                'begintijd' => '14:00:00',
                'eindtijd' => '16:00:00',
                'aantal_volwassenen' => 2,
                'aantal_kinderen' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'persoon_id' => 2,
                'datum' => '2023-10-02',
                'aantal_uren' => 3,
                'begintijd' => '15:00:00',
                'eindtijd' => '18:00:00',
                'aantal_volwassenen' => 3,
                'aantal_kinderen' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

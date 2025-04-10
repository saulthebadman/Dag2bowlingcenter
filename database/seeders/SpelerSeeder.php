<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Speler;
use App\Models\Score;

class SpelerSeeder extends Seeder
{
    public function run(): void
    {
        Speler::factory()
            ->count(5)
            ->has(
                Score::factory()->count(3) // elke speler krijgt 3 scores
            )
            ->create();
    }
}


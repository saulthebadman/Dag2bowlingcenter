<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactSeeder extends Seeder
{
    public function run()
    {
        // Genereer 50 dummy contacten
        Contact::factory()->count(10)->create();
    }
}

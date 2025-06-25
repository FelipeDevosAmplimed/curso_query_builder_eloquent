<?php

namespace Database\Seeders;

use App\Models\Eventos;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Eventos::factory(5)->create();
    }
}

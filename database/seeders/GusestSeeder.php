<?php

namespace Database\Seeders;

use App\Models\Guests;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GusestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Guests::factory()->count(500)->create();
    }
}

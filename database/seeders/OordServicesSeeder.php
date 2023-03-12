<?php

namespace Database\Seeders;

use App\Models\OordService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OordServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OordService::factory()->count(500)->create();
    }
}

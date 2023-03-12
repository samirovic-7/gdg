<?php

namespace Database\Seeders;

use App\Models\MealPackage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MealBackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MealPackage::create([
            'package_code' => 1,
            'name' => 'sss',
            'name_loc' => 'sdsd',
        ]);
    }
}

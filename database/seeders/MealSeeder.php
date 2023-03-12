<?php

namespace Database\Seeders;

use App\Models\Meal;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Meal::create([
            'meal_code' => '12',
            'name' => 'sdsd',
            'name_loc' => 'asd',
            'price' => 5646,
            'ledger_id' => 1,
        ]);
    }
}

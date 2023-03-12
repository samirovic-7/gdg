<?php

namespace Database\Seeders;

use App\Models\Window;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class windowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Window::create([
            'guest_id' => 1,
            'window_number' => 1,
            'window_name' =>'windw1',
            'invoice_number' => '1',
        ]);
    }
}

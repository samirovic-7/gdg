<?php

namespace Database\Seeders;

use App\Models\RoomStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $statuses = [
            [
                 ,
                'name' => 'Vacant/Clean',
                'name_loc' => 'شاغرة/نظيفة',
                'color' => '11111'
            ],
            [
                'status_code' => 'VADI',
                'name' => 'Vacant/Dirty',
                'name_loc' => 'شاغرة/غير نظيفة',
                'color' => '11111'
            ],
            [
                'status_code' => 'BLCL',
                'name' => 'Blocked/Clean',
                'name_loc' => 'محجوزة/نظيفة',
                'color' => '11111'
            ],
            [
                'status_code' => 'BLDI',
                'name' => 'Blocked/Dirty',
                'name_loc' => 'محجوزة/غير نظيفة',
                'color' => '11111'
            ],
            [
                'status_code' => 'BLOC',
                'name' => 'Blocked/Occupied',
                'name_loc' => 'محجوزة/ساكنة',
                'color' => '11111'
            ],
            [
                'status_code' => 'OCCL',
                'name' => 'Occupied/Clean',
                'name_loc' => 'ساكنة/نظيفة',
                'color' => '11111'
            ],
            [
                'status_code' => 'OCDI',
                'name' => 'Occupied/Dirty',
                'name_loc' => 'ساكنة/غير نظيفة',
                'color' => '11111'
            ],
            [
                'status_code' => 'DO',
                'name' => 'Due Out',
                'name_loc' => 'متوقع مغادرة',
                'color' => '11111'
            ],
            [
                'status_code' => 'OO',
                'name' => 'Out of Order',
                'name_loc' => 'خارج الطلب',
                'color' => '11111'
            ],
            [
                'status_code' => 'OS',
                'name' => 'Out Of Service',
                'name_loc' => 'خارج الخدمة',
                'color' => '11111'
            ],
        ];

        foreach ($statuses as $status) {
            DB::table('room_statuses')->insert($status);
        }
    }
}

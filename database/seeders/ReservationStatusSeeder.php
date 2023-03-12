<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReservationStatusSeeder extends Seeder
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
                'res_status_code' => 'CNF',
                'name' => 'Confirm',
                'name_loc' => 'مؤكد',
                'color' => '11111',
            ],
            [
                'res_status_code' => 'NCF',
                'name' => 'Non Confirm',
                'name_loc' => 'غير مؤكد',
                'color' => '11111',
            ],
            [
                'res_status_code' => 'CNC',
                'name' => 'Cancel',
                'name_loc' => 'تم الإلغاء',
                'color' => '11111',
            ],
            [
                'res_status_code' => 'NSH',
                'name' => 'No Show',
                'name_loc' => 'لم يحضر',
                'color' => '11111',
            ],
            [
                'res_status_code' => 'CHK',
                'name' => 'Checked in',
                'name_loc' => 'تم التسكين',
                'color' => '11111',
            ],
            [
                'res_status_code' => 'WLT',
                'name' => 'Waiting List',
                'name_loc' => 'قائمة الإنتظار',
                'color' => '11111',
            ],
        ];
    
        DB::table('reservation_statuses')->insert($statuses);
    }
}

<?php

namespace Database\Seeders;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Room::create([ 
        //     'rm_name_en'       => 'rome1',
        //     'rm_name_loc'             => 'rome1',
        //     'rm_max_pax' => 1,
        //     'rm_phone_no'      => '1234',
        //     'rm_phone_ext'      => '123456',
        //     'rm_key_code'      => '1236',
        //     'rm_key_options'      =>1,
        //     'rm_connection'      => 1,
        //     'fo_status'      => 'ss',
        //     'rm_active'      => 1,
        //     'hk_stauts'      => 1,
        //     'sort_order'      =>1,
        //     'room_type_id'      => 1,
        //     'floor_id'      => 1,
        // ]);
        Room::factory()->count(500)->create();


    }
}

<?php

namespace Database\Seeders;

use App\Models\guest_profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuestProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        guest_profile::create([
            'Profile_no' =>1,
            'first_name' =>'GuestProfile1',
            'last_name' =>'sdf',
            'id_no' =>'01650',
            'mobile' =>'01145613',
            'phone' =>'210143131',
            'email' =>'as@gmail.com',
            'address' =>' address1',
            'country_id' =>1,
            'city' =>'sad',
            'language' =>'en',
            'date_of_birth' =>fake()->date(),
            'gender' =>'femal',
            'created_by' =>1,      
        ]);
    }
}

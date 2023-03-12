<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use App\Models\RoomType;

use App\Models\ReservationStatus;

use Illuminate\Database\Seeder;
use Database\Seeders\MealSeeder;
use Database\Seeders\RoomChange;
use Database\Seeders\RoomSeeder;
use Database\Seeders\OwnerSeeder;
use Database\Seeders\GusestSeeder;
use Database\Seeders\MarketSeeder;
use Illuminate\Support\Facades\DB;

use Database\Seeders\CountrySeeder;
use Database\Seeders\RateCodeSeeder;
use Database\Factories\RoomTypeFactory;
use Database\Seeders\GuestProfileSeeder;

use Database\Seeders\RoomStatusSeeder;
use Database\Seeders\CheckStatusSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        /* $this->call([
            RoomTypeSeeder::class,
            RoleSeeder::class,
            permissionSeeder::class,
            OwnerSeeder::class,
        ]); */
        // DB::table('settings')->insert([
        //     'name' => "Acme Inc.",
        //     'name_loc' => "شركة آكمي المحدودة",
        //     'type' => "Corporation",
        //     'cr_no' => "12345",
        //     'phone' => "555-1234",
        //     'mobile' => "555-5678",
        //     'email' => "info@acme.com",
        //     'city' => "New York",
        //     'address' => "123 Main St.",
        //     'vat_no' => "5",
        // ]);
        // DB::table('ledger_cats')->insert([
        //     'name' => "category",
        //     'name_loc' => "cat",
        // ]);

        // $this->call([
        //     RoomStatusSeeder::class
        // ]);
        $this->call([

            //RoomChange::class
            RoomTypeSeeder::class, 
          // OwnerSeeder::class,
            RoomSeeder::class,
            CountrySeeder::class,
            GuestProfileSeeder::class, 
            BusenessSeeder::class,
            LeadgerSeder::class,
            RateCodeSeeder::class, 
            MealSeeder::class,
            MarketSeeder::class,   
            OordServicesSeeder::class,  
            GusestSeeder::class,       
         ]);


           // ReservationStatusSeeder::class,

          //  RoomTypeSeeder::class,
          //  FloorSeeder::class,
          //  CheckStatusSeeder::class

      //  ]);




    }
}

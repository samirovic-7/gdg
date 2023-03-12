<?php

namespace Database\Factories;

use App\Models\companyProfile;
use App\Models\guest_profile;
use App\Models\Market;
use App\Models\Meal;
use App\Models\RateCode;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\SourceBusiness;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Guest>
 */
class GuestsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $roomIDs=[];
        $roomsId=Room::where('fo_status','OC')->get('id');
        foreach($roomsId as $roomID)
        {
            array_push($roomIDs,$roomID->id);
        }
       
        return [
            'folio_no' => fake()->unique()->randomNumber(),
             'in_date' => fake()->date(),
             'out_date' =>fake()->dateTimeBetween("01-04-2023","20-04-2023"),
             'original_out_date' => fake()->dateTimeBetween("15-04-2023","30-04-2023"),
             'no_of_nights' =>fake()->numberBetween(5,30),
             'rm_rate' => fake()->numberBetween(1000,5000),
             'taxes' => fake()->randomFloat(1, 0.05, 0.025),
             'no_of_pax' =>fake()->numberBetween(1,5),
             'hotel_note' => fake()->text(),
             'client_note' =>fake()->text(),
             'way_of_payment' =>fake()->name(),
             'profile_id' =>fake()->numberBetween(1,guest_profile::count()),
             'company_id' =>fake()->numberBetween(1,companyProfile::count()),
             'room_id' =>fake()->randomElement($roomIDs), 
             'room_type_id' =>fake()->numberBetween(1,RoomType::count()),
             'rate_code_id' => fake()->numberBetween(1,RateCode::count()),
             'market_segment_id' =>fake()->numberBetween(1,Market::count()),
             'source_of_business_id' => fake()->numberBetween(1,SourceBusiness::count()),
             'meal_id' => fake()->numberBetween(1,Meal::count()),
             'created_by' => fake()->numberBetween(1,User::count()),
             'created_inhousGuest_at' =>fake()->date(),
             'checked_out' =>fake()->boolean(),
             'checkout_by' => fake()->numberBetween(14,User::count()),
             'checkout_at' => fake()->dateTimeBetween("01-04-2023","20-04-2023"),
             'is_reservation' => fake()->boolean(),
             'res_status' => fake()->randomElement(['CNF','NCF','CNC','NSH']),
             'is_group' => fake()->boolean(),
             'group_code' => fake()->countryCode(),
             'is_dummy' =>fake()->boolean(),
             'Is_PM' =>fake()->boolean(),
             'is_cancel' => fake()->boolean(),
             'is_checked_in' => fake()->boolean(),
             'res_no' => fake()->randomDigit(1,49),
             'is_online' => fake()->boolean(),
             'ref_no' => fake()->randomDigit(1,49)
        ];
    }
}

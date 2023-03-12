<?php

namespace Database\Factories;

use App\Models\Floor;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'rm_name_en' => fake()->unique()->name(),
            'rm_name_loc' => fake()->unique()->name(),
            'rm_max_pax' => fake()->numberBetween(1,4),
            'rm_phone_no' => fake()->phoneNumber() ,
            'rm_phone_ext' => fake()->phoneNumber(),
            'rm_key_code' => fake()->countryCode(),
            'rm_key_options' => fake()->countryCode(),
            'rm_connection' => fake()->boolean(),
            'fo_status' => fake()->randomElement(['VA', 'CN', 'OC', 'OO', 'OS']),
            'hk_stauts' => fake()->randomElement(['DI','CN']),
            'rm_active' => fake()->boolean(),
            'sort_order' => 1,
            'room_type_id' => fake()->numberBetween(1,RoomType::count()),
            'floor_id' => fake()->numberBetween(1,Floor::count()),
        ];
    }
}

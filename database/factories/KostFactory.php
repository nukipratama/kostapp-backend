<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class KostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create('id_ID');
        return [
            'name' => 'Kos ' . $faker->company(),
            'location' => $faker->streetName(),
            'price' => $faker->numberBetween(15, 30) * 100000,
            'description' => $faker->paragraph()
        ];
    }
}

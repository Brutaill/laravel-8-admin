<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    
    private static $order = 1;
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'Project-'. str_pad( self::$order++ , 4, '0', STR_PAD_LEFT),
            'description' => $this->faker->sentence(10),
            'client_id' => Client::inRandomOrder()->first()->id,
            'deadline' => $this->faker->dateTimeBetween('+1 month', '+5 month'),
        ];
    }
}

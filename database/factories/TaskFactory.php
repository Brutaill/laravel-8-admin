<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->sentence(20),
            'client_id' => Project::find(1)->client->id,
            'project_id' => Project::find(1)->id,
            'user_id' => Project::find(1)->users()->first()->id,
        ];
    }
}

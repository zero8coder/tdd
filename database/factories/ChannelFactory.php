<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChannelFactory extends Factory
{

    public function definition()
    {
        $name = $this->faker->word;
        return [
            'name' => $name,
            'slug' => $name
        ];
    }
}

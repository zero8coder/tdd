<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThreadFactory extends Factory
{

    public function definition(): array
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'channel_id' => function () {
                return Channel::factory()->create()->id;
            },
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'visits' => 0
        ];
    }
}

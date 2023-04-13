<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ThreadFactory extends Factory
{

    public function definition(): array
    {
        $title = $this->faker->sentence;
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'channel_id' => function () {
                return Channel::factory()->create()->id;
            },
            'title' => $title,
            'body' => $this->faker->paragraph,
            'visits' => 0,
            'slug' => Str::slug($title),
            'locked' => false
        ];
    }
}

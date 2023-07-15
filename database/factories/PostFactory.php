<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $thumb =  fake()->image("public/images/posts", 640, 480);
        $title = fake()->sentence(3);

        return [
            'title' => $title,
            "content" => fake()->paragraph(),
            "slug" => Str::slug($title),
            "user_id" => User::pluck("id")->random(),
            'thumb' => str_replace("public","",$thumb),
        ];
    }
}

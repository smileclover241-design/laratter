<?php

namespace Database\Factories;

// 🔽 2行追加
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    // 🔽 追加
    return [
      'comment' => fake()->sentence(),
      'user_id' => User::factory(),
      'tweet_id' => Tweet::factory(),
    ];
  }
}
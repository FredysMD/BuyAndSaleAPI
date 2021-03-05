<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content' => $this->faker->paragraph(1),
            'comment_parent_id' => $this->faker->randomElement($this->comments(), null),
            'product_id' => Product::all()->random()->id,
            'user_id' => User::all()->random()->id,
        ];
    }

    public function comments()
    {
        return count(Comment::all()) > 1 ? Comment::all()->random()->id : null;
    }
}

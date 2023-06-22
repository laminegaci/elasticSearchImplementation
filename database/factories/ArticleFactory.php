<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
     protected $model = Article::class;
     public function definition()
     {
         return [
             'title' => $this->faker->sentence(),
             'body' => $this->faker->text(),
             'tags' => collect(['php', 'ruby', 'java', 'javascript', 'bash'])
                 ->random(2)
                 ->values()
                 ->all(),
         ];
     }
}

<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Postings;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PostingsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Postings::class;
    protected $connection = 'mysql_post';

    public function definition(): array
    {
    }
}

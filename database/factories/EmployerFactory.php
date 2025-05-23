<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employer>
 */
class EmployerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    public function definition(): array
    {
        //    for testing only:
        Category::create([
            'name' => fake()->unique()->name()
        ]);
        return [
            'name' => fake()->name(),
            'category_id' => Category::inRandomOrder()->first()->id,
            'user_id' => User::factory()
        ];
    }
}

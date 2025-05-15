<?php

namespace Database\Factories;

use App\Models\Employer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $employer = Employer::factory()->create();
        return [
            'employer_id' => Employer::factory(),
            'category_id' => $employer->category_id,
            'title' => fake()->jobTitle(),
            'salary' => fake()->randomElement(['$50,000 USD', '$90,000 USD', '$150,000 USD', '$200,000 USD']),
            'about' => fake()->realText(),
            'top' => false,
            'location' => 'Remote',
            'schedule' => 'Full Time',
            'url' => fake()->url,
        ];
    }
}

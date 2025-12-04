<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'category_id' => 1,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'logo' => 'https://picsum.photos/200?random=' . rand(1, 1000),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Configure the model factory.
     */
//    public function configure()
//    {
//        return $this->afterCreating(function (User $user) {
//            //...
//        });
//    }

    /**
     * Indicate that the user is suspended.
     */
//    public function suspended(): Factory
//    {
//        return $this->state(function (array $attributes) {
//            return [
//                'account_status' => 'suspended',
//            ];
//        });
//    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
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
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_verified' => true, // Default to verified for testing
            'verified_at' => now(),
            'role' => 'petani', // Default role
        ];
    }

    /**
     * Indicate that the model should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'is_verified' => false,
                'verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the model should be verified.
     */
    public function verified(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'is_verified' => true,
                'verified_at' => now(),
            ];
        });
    }
}

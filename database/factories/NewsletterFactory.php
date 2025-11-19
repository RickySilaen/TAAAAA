<?php

namespace Database\Factories;

use App\Models\Newsletter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Newsletter>
 */
class NewsletterFactory extends Factory
{
    protected $model = Newsletter::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['active', 'unsubscribed']);
        $createdAt = fake()->dateTimeBetween('-1 year', 'now');

        return [
            'email' => fake()->unique()->safeEmail(),
            'nama' => fake()->optional(0.7)->name(),
            'status' => $status,
            'subscribed_at' => $createdAt,
            'unsubscribed_at' => $status === 'unsubscribed' ? fake()->dateTimeBetween($createdAt, 'now') : null,
            'created_at' => $createdAt,
            'updated_at' => $status === 'unsubscribed' ? fake()->dateTimeBetween($createdAt, 'now') : $createdAt,
        ];
    }

    /**
     * Indicate that the newsletter subscription is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'unsubscribed_at' => null,
        ]);
    }

    /**
     * Indicate that the newsletter subscription is unsubscribed.
     */
    public function unsubscribed(): static
    {
        return $this->state(function (array $attributes) {
            $subscribedAt = $attributes['subscribed_at'] ?? now()->subMonths(6);

            return [
                'status' => 'unsubscribed',
                'unsubscribed_at' => fake()->dateTimeBetween($subscribedAt, 'now'),
            ];
        });
    }
}

<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'icon' => file_get_contents('data:image/jpeg;base64,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'),
            'icon_mime' => 'image/jpeg',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}

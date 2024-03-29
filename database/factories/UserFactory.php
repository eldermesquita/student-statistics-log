<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Role;

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
            'name' => $this->faker->firstName,
            'patronymic' => $this->faker->middleName(),
            'surname' => $this->faker->lastName,
            'username' => $this->faker->unique()->userName,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'role' => User::ROLE_GUEST
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

    public function admin(): UserFactory
    {
        return $this->state(function (array $attributes) {
           return [
               'role' => User::ROLE_ADMIN
           ];
        });
    }

    public function teacher(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => User::ROLE_TEACHER
            ];
        });
    }

    public function guest(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => User::ROLE_TEACHER
            ];
        });
    }

    public function root(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => User::ROLE_ROOT
            ];
        });
    }
}

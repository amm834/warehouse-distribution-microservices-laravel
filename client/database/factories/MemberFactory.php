<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role' => \App\Enum\RoleEnum::USER->value,
            'company_id' => \App\Models\Company::factory(),
            'client_id' => \App\Models\Client::factory(),
        ];
    }
}

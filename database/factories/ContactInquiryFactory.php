<?php

namespace Database\Factories;

use App\Models\ContactInquiry;
use App\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContactInquiry>
 */
class ContactInquiryFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'company' => fake()->company(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'package' => fake()->randomElement(Package::cases()),
            'message' => fake()->paragraph(),
            'locale' => 'sv',
        ];
    }
}

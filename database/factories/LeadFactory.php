<?php

namespace Database\Factories;

use App\Enums\LeadStatus;
use App\Models\Lead;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lead>
 */
class LeadFactory extends Factory
{
    protected $model = Lead::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'phone' => fake()->e164PhoneNumber(),
            'email' => fake()->optional()->safeEmail(),
            'message' => fake()->optional()->paragraph(),
            'property_id' => Property::factory(),
            'status' => LeadStatus::New,
            'source' => fake()->randomElement(['contact_form', 'property_inquiry', 'whatsapp']),
        ];
    }
}

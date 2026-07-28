<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Member;

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
            'start_date' => now(),
            'end_date' => now()->addMonths(6),
            
            'sent_interested' => 10,
            'profiles_allowed' => 100,
            'messages_allowed' => 50,
            'contacts_allowed' => 20,
            
            'status' => 'active',
            'active' => true,
            'is_verified' => true,
            'membership_expired' => false,
            
            'profiles_used' => $this->faker->numberBetween(0, 50),
            'contacts_used' => $this->faker->numberBetween(0, 10),
            
            'member_no' => 'MEM' . $this->faker->unique()->numberBetween(10000, 99999),
        ];
    }
}

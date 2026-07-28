<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Profile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = $this->faker->randomElement(['male', 'female']);
        
        return [
            'gender' => $gender,
            'dob' => $this->faker->date('Y-m-d', '-20 years'),
            'age' => $this->faker->numberBetween(21, 45),
            'marital_status' => $this->faker->randomElement(['single', 'divorced', 'widowed']),
            'profile_created_for' => $this->faker->randomElement(['myself', 'son', 'daughter', 'sibling']),
            'registration_mode' => 'online',

            'caste' => $this->faker->randomElement(['General', 'OBC', 'SC', 'ST']),
            'gothram' => $this->faker->word,
            'about_me' => $this->faker->sentence(10),

            // Location
            'country' => 'India',
            'state' => 'Tamil Nadu',
            'city' => $this->faker->randomElement(['Chennai', 'Coimbatore', 'Madurai', 'Trichy', 'Salem']),

            // Education & Career
            'education' => $this->faker->randomElement(['B.E', 'B.Tech', 'MBA', 'MBBS', 'B.Com', 'M.Sc']),
            'occupation' => $this->faker->randomElement(['Software Engineer', 'Doctor', 'Teacher', 'Banker', 'Business']),
            'income' => $this->faker->randomElement(['3-5 LPA', '5-8 LPA', '10-15 LPA', '15+ LPA']),
            
            // Physical
            'height' => $this->faker->numberBetween(150, 190),
            'weight' => $this->faker->numberBetween(50, 90),
            'complexion' => $this->faker->randomElement(['fair', 'wheatish', 'dark']),
            'body_type' => $this->faker->randomElement(['average', 'athletic', 'slim', 'heavy']),
        ];
    }
}

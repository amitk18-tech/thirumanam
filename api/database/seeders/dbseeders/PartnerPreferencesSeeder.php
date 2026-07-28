<?php

namespace Database\Seeders\dbseeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\PartnerPreference;

class PartnerPreferencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first 7 profiles dynamically
        $profiles = Profile::limit(7)->get();

        if ($profiles->count() < 7) {
            $this->command->error('Not enough profiles found for PartnerPreferencesSeeder. Need at least 7 profiles.');
            return;
        }

        $partnerPreferences = [
            [
                'profile_id' => 1,
                'preferred_age_min' => 24,
                'preferred_age_max' => 30,
                'preferred_height_min' => 160,
                'preferred_height_max' => 175,
                'marital_status' => 'single',
                'caste' => 'Brahmin',
                'education' => 'B.Tech / M.Tech',
                'dosham' => 'no',
                'about_partner' => 'Looking for an educated, family-oriented, and understanding partner.',
            ],
            [
                'profile_id' => 2,
                'preferred_age_min' => 22,
                'preferred_age_max' => 28,
                'preferred_height_min' => 155,
                'preferred_height_max' => 170,
                'marital_status' => 'single',
                'caste' => 'Kshatriya',
                'education' => 'MBA / PGDM',
                'dosham' => 'no',
                'about_partner' => 'Seeking a caring and ambitious partner with good values.',
            ],
            [
                'profile_id' => 3,
                'preferred_age_min' => 26,
                'preferred_age_max' => 32,
                'preferred_height_min' => 165,
                'preferred_height_max' => 180,
                'marital_status' => 'single',
                'caste' => 'Vaishya',
                'education' => 'CA / CS',
                'dosham' => 'yes',
                'about_partner' => 'Looking for a professional with strong family background.',
            ],
            [
                'profile_id' => 4,
                'preferred_age_min' => 23,
                'preferred_age_max' => 29,
                'preferred_height_min' => 158,
                'preferred_height_max' => 172,
                'marital_status' => 'divorced',
                'caste' => 'Shudra',
                'education' => 'Graduate',
                'dosham' => 'no',
                'about_partner' => 'Seeking a loyal and honest life partner.',
            ],
            [
                'profile_id' => 5,
                'preferred_age_min' => 25,
                'preferred_age_max' => 35,
                'preferred_height_min' => 162,
                'preferred_height_max' => 178,
                'marital_status' => 'single',
                'caste' => 'Brahmin',
                'education' => 'Doctor',
                'dosham' => 'no',
                'about_partner' => 'Looking for a well-educated professional partner.',
            ],
            [
                'profile_id' => 6,
                'preferred_age_min' => 21,
                'preferred_age_max' => 27,
                'preferred_height_min' => 150,
                'preferred_height_max' => 165,
                'marital_status' => 'single',
                'caste' => 'Kshatriya',
                'education' => 'Post Graduate',
                'dosham' => 'yes',
                'about_partner' => 'Seeking a kind-hearted and supportive partner.',
            ],
            [
                'profile_id' => 7,
                'preferred_age_min' => 27,
                'preferred_age_max' => 33,
                'preferred_height_min' => 168,
                'preferred_height_max' => 185,
                'marital_status' => 'widowed',
                'caste' => 'Vaishya',
                'education' => 'Engineer',
                'dosham' => 'no',
                'about_partner' => 'Looking for a mature and understanding life companion.',
            ],
        ];

        foreach ($partnerPreferences as $preference) {
            PartnerPreference::create($preference);
        }
    }
}
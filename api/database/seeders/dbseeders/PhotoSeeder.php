<?php

namespace Database\Seeders\dbseeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\Photo;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminProfile = Profile::whereHas('user', fn($q) => $q->where('email', 'admin@example.com'))->first();
        $userProfile  = Profile::whereHas('user', fn($q) => $q->where('email', 'user@example.com'))->first();

        if ($adminProfile) {
            Photo::updateOrCreate(
                ['profile_id' => $adminProfile->id, 'photo_url' => 'https://example.com/images/profile1.jpg'],
                [
                    'is_primary' => true,
                    'is_private' => false,
                ]
            );

            Photo::updateOrCreate(
                ['profile_id' => $adminProfile->id, 'photo_url' => 'https://example.com/images/profile1_2.jpg'],
                [
                    'is_primary' => false,
                    'is_private' => false,
                ]
            );
        }

        if ($userProfile) {
            Photo::updateOrCreate(
                ['profile_id' => $userProfile->id, 'photo_url' => 'https://example.com/images/profile2.jpg'],
                [
                    'is_primary' => true,
                    'is_private' => true,
                ]
            );
        }
    }
}
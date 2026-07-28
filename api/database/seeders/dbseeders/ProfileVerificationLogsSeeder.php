<?php

namespace Database\Seeders\dbseeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\User;
use App\Models\ProfileVerificationLog;

class ProfileVerificationLogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profile1 = Profile::first();
        $profile2 = Profile::skip(1)->first();
        $admin = User::first(); // assuming `users` table stores admins too

        if (!$profile1 || !$profile2 || !$admin) {
            $this->command->error('Not enough data (profiles/admin) to seed profile_verification_logs.');
            return;
        }

        ProfileVerificationLog::updateOrCreate(
            ['profile_id' => $profile1->id, 'admin_id' => $admin->id],
            [
                'action' => 'verify',
                'reason' => 'Profile verified after ID proof submission.',
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(7),
            ]
        );

        ProfileVerificationLog::updateOrCreate(
            ['profile_id' => $profile2->id, 'admin_id' => $admin->id],
            [
                'action' => 'block',
                'reason' => 'Blocked due to repeated violations of community guidelines.',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ]
        );
    }
}
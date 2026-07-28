<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\dbseeders\RoleSeeder;
use Database\Seeders\dbseeders\UserSeeder;
use Database\Seeders\dbseeders\PermissionsSeeder;
use Database\Seeders\dbseeders\RolePermissionSeeder;
use Database\Seeders\dbseeders\FamilyDetailSeeder;
use Database\Seeders\dbseeders\MatchActionsSeeder;
use Database\Seeders\dbseeders\MessagesSeeder;
use Database\Seeders\dbseeders\PaymentsSeeder;
use Database\Seeders\dbseeders\PartnerPreferencesSeeder;
use Database\Seeders\dbseeders\ProfileSeeder;
use Database\Seeders\dbseeders\ProfileVerificationLogsSeeder;
use Database\Seeders\dbseeders\MembershipsSeeder;
use Database\Seeders\dbseeders\ReportsSeeder;
use Database\Seeders\dbseeders\PhotoSeeder;
use Database\Seeders\dbseeders\MemberSeeder;
use Database\Seeders\dbseeders\InterestsSeeder;
use Database\Seeders\dbseeders\ProfileActionSeeder;
use Database\Seeders\dbseeders\HoroscopeBoxSeeder;




class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionsSeeder::class,
            RolePermissionSeeder::class,
            UserSeeder::class,
            ProfileSeeder::class,
            FamilyDetailSeeder::class,
            // MatchActionsSeeder::class,
            PhotoSeeder::class,
            MessagesSeeder::class,
            // PaymentsSeeder::class,
            PartnerPreferencesSeeder::class,
            ProfileVerificationLogsSeeder::class,
            MembershipsSeeder::class,
            MemberSeeder::class,
            InterestsSeeder::class,
            ProfileActionSeeder::class,
            HoroscopeBoxSeeder::class,
            // ReportsSeeder::class


        ]);
    }
}

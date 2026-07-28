<?php

namespace Database\Seeders\dbseeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reports')->insert([
            [
                'reporter_id' => 1,
                'reported_id' => 2,
                'handled_by' => null,
                'reason' => 'User sent inappropriate messages.',
                'status' => 'pending',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'reporter_id' => 3,
                'reported_id' => 4,
                'handled_by' => 1,
                'reason' => 'Fake profile suspected.',
                'status' => 'reviewed',
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(3),
            ],
            [
                'reporter_id' => 5,
                'reported_id' => 1,
                'handled_by' => 2,
                'reason' => 'Harassment via chat.',
                'status' => 'closed',
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(2),
            ],
            [
                'reporter_id' => 6,
                'reported_id' => 3,
                'handled_by' => null,
                'reason' => 'Sharing offensive images.',
                'status' => 'pending',
                'created_at' => now()->subDay(),
                'updated_at' => now()->subDay(),
            ],
        ]);
    }
}
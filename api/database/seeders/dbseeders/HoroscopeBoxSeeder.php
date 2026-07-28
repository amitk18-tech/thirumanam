<?php

namespace Database\Seeders\dbseeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\HoroscopeBox;
use App\Models\Membership;

class HoroscopeBoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Profile 1 - Box 1 to 12
        for ($box = 1; $box <= 12; $box++) {
            HoroscopeBox::create([
                'profile_id' => 1,
                'box_number' => $box,
                'item_number' => 1,
                'type' => 'zodiac',
                'value' => 'Sun',
            ]);
        }

        // Profile 2 - Box 1 to 12
        for ($box = 1; $box <= 12; $box++) {
            HoroscopeBox::create([
                'profile_id' => 2,
                'box_number' => $box,
                'item_number' => 1,
                'type' => 'zodiac',
                'value' => 'lakknam',
            ]);
        }
    }
}

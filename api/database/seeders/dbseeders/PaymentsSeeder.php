<?php

namespace Database\Seeders\dbseeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payments')->insert([
            [
                'user_id' => 1,
                'amount' => 499.00,
                'payment_mode' => 'card',
                'transaction_id' => 'TXN123456789',
                'status' => 'success',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'user_id' => 2,
                'amount' => 1499.00,
                'payment_mode' => 'upi',
                'transaction_id' => 'TXN987654321',
                'status' => 'failed',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
        ]);
    }
}
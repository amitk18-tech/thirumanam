<?php

namespace App\Console\Commands;

use App\Models\Member;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ExpireMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'members:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set members inactive when created_at is older than 6 months';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $cutoffDate = Carbon::now()->subMonths(6);

        $updatedCount = Member::query()
            ->where('status', 'active')
            ->where('created_at', '<=', $cutoffDate)
            ->update([
                'status' => 'inactive',
                'membership_expired' => true,
                'updated_at' => now(),
            ]);

        $this->info("Members expired successfully. Updated rows: {$updatedCount}");

        return self::SUCCESS;
    }
}
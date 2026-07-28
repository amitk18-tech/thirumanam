<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportMemberActivities extends Command
{
    protected $signature = 'import:member-activities';
    protected $description = 'Import member activities from JSON file';

    public function handle()
    {
        $filePath = storage_path('app/member_activities.json');

        if (!File::exists($filePath)) {
            $this->error('File not found!');
            return;
        }

        $json = File::get($filePath);
        $activities = json_decode($json, true);

        foreach ($activities as $item) {
            DB::table('member_activities')->insert([
                'member_id'     => $item['member_id'],
                'name'          => '', // default
                'mobile'        => '', // default
                'activity_type' => $item['activity'],
                'location'      => $item['location'] ?? null,
                'status'        => $item['status'] ?? null,
                'created_at'    => $item['created_date'],
                'updated_at'    => $item['updated_date'],
            ]);
        }

        $this->info('Member activities imported successfully!');
    }
}

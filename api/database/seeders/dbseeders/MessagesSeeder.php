<?php

namespace Database\Seeders\dbseeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\MatchAction;
use App\Models\Message;

class MessagesSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch two profiles
        $profile1 = Profile::whereHas('user', fn($q) => $q->where('email', 'superadmin@example.com'))->first();
        $profile2 = Profile::whereHas('user', fn($q) => $q->where('email', 'customer@example.com'))->first();

        if (!$profile1 || !$profile2) {
            $this->command->error('Profiles not found for messages seeding.');
            return;
        }

        // Get or create a match between these two profiles (any direction)
        $match = MatchAction::where(function ($q) use ($profile1, $profile2) {
            $q->where('sender_profile_id', $profile1->id)
                ->where('receiver_profile_id', $profile2->id);
        })
            ->orWhere(function ($q) use ($profile1, $profile2) {
                $q->where('sender_profile_id', $profile2->id)
                    ->where('receiver_profile_id', $profile1->id);
            })
            ->first();

        if (!$match) {
            $match = MatchAction::create([
                'sender_profile_id' => $profile1->id,
                'receiver_profile_id' => $profile2->id,
                'action_type' => 'interest_sent', // or whatever default you use (e.g. "like", "connect")
            ]);

        }

        // Messages array
        $messages = [
            [
                'sender_profile_id' => $profile1->id,
                'receiver_profile_id' => $profile2->id,
                'message_text' => 'Hi, I really liked your profile!',
                'message_type' => 'text',
                'is_read' => false,
            ],
            [
                'sender_profile_id' => $profile2->id,
                'receiver_profile_id' => $profile1->id,
                'message_text' => 'Thank you! Nice to connect with you.',
                'message_type' => 'text',
                'is_read' => true,
            ],
        ];

        foreach ($messages as $msg) {
            $message = Message::updateOrCreate(
                [
                    'match_id' => $match->id,
                    'sender_profile_id' => $msg['sender_profile_id'],
                    'receiver_profile_id' => $msg['receiver_profile_id'],
                    'message_text' => $msg['message_text'],
                ],
                [
                    'message_type' => $msg['message_type'],
                    'is_read' => $msg['is_read'],
                ]
            );
            $this->command->info("Message seeded: {$message->message_text}");
        }

        $this->command->info('Messages seeded successfully.');
    }
}
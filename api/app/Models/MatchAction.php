<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_profile_id',
        'receiver_profile_id',
        'action_type',
        'notes',
    ];

    /**
     * Relationships
     */
    public function senderProfile()
    {
        return $this->belongsTo(Profile::class, 'sender_profile_id');
    }

    public function receiverProfile()
    {
        return $this->belongsTo(Profile::class, 'receiver_profile_id');
    }
}
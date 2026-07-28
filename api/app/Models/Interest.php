<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    protected $fillable = [
        'sender_profile_id',
        'receiver_profile_id',
        'status',
        'responded_at'
    ]; 

    public function sender()
    {
        return $this->belongsTo(Profile::class, 'sender_profile_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Profile::class, 'receiver_profile_id');
    }
}

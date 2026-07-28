<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileAction extends Model
{
    protected $fillable = [
        'from_profile_id',
        'to_profile_id',
        'action_type'
    ];

        public function fromProfile()
    {
        return $this->belongsTo(Profile::class, 'from_profile_id');
    }

    // Action receiver profile
    public function toProfile()
    {
        return $this->belongsTo(Profile::class, 'to_profile_id');
    }
}
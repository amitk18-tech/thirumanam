<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileReport extends Model
{
    protected $fillable = [
        'reported_by_profile_id',
        'reported_profile_id',
        'reason',
        'description'
    ];

    public function reportedProfile()
    {
        return $this->belongsTo(Profile::class, 'reported_profile_id');
    }

    public function reportedByProfile()
    {
        return $this->belongsTo(Profile::class, 'reported_by_profile_id');
    }
}

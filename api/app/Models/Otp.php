<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $fillable = [
        'mobile',
        'otp_hash',
        'type',
        'expires_at',
        'is_used',
    ];
}

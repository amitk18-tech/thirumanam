<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileVerificationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'admin_id',
        'action',
        'reason',
    ];

    /**
     * Relationships
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
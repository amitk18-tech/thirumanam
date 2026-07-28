<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'name',
        'mobile',
        'activity_type',
        'location',
        'status'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
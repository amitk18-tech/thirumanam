<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [

        'membership_id',
        'profile_id',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'amount',
        'status',
        'payment_mode',
        'transaction_date',
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
        'amount' => 'decimal:2',
    ];

    protected $with = ['profile.user', 'profile.member', 'membership'];

    protected $appends = ['profile_name', 'membership_name', 'created_at_formatted', 'member_no'];

    public function getProfileNameAttribute()
    {
        return $this->profile && $this->profile->user ? $this->profile->user->name : 'N/A';
    }

    public function getMembershipNameAttribute()
    {
        return $this->membership ? $this->membership->name : 'N/A';
    }

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at ? $this->created_at->format('d-m-Y h:i a') : 'N/A';
    }

    public function getMemberNoAttribute()
    {
        return $this->profile && $this->profile->member ? $this->profile->member->member_no : 'N/A';
    }

    // Relationship to Member (User)
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    // Relationship to Profile
    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    // Relationship to Membership Plan
    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\Message;

class Member extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'profile_id',
        'membership_id',
        'payment_id',
        'legacy_member_id',
        'start_date',
        'end_date',
        'sent_interest_allowed',
        'profiles_view_allowed',
        'messages_sent_allowed',

        'sent_interest_remaining',
        'profiles_view_remaining',
        'messages_sent_remaining',

        'membership_expired',
        'is_profile_complete',
        'send_reminder',
        'auto_renewal',
        'isRenewed',
        'status',
        'is_verified',
        'is_reported',
        'is_deactivated',
        'is_matched',
        'verified_by_admin',
        'blocked_by_admin',
        'rejected_by_admin',
        'rejection_reason',
        'is_deleted',
        'is_closed',
        'member_no',
        'prefix_id',
        'legacy_member_id'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'send_reminder' => 'boolean',
        'auto_renewal' => 'boolean',
        'is_profile_complete' => 'boolean',
        'active' => 'boolean',
        'isRenewed' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'member_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('active', false);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCurrentlyActive($query)
    {
        return $query
            ->where('status', 'active')
            ->whereDate('end_date', '>=', now());
    }

    public function scopeExpired($query)
    {
        return $query->whereDate('end_date', '<', now());
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeAutoRenewal($query)
    {
        return $query->where('auto_renewal', true);
    }

    public function scopeWithReminder($query)
    {
        return $query->where('send_reminder', true);
    }

    public function scopeExpiringSoon($query, $days = 7)
    {
        $today = Carbon::today();
        $end = $today->copy()->addDays($days);

        return $query->whereBetween('end_date', [$today, $end]);
    }

    public function scopeActiveAndExpiringSoon($query, $days = 7)
    {
        return $query->currentlyActive()->expiringSoon($days);
    }

    public function scopeAutoRenewing($query)
    {
        return $query->active()->autoRenewal();
    }

    public function scopeOfMembership($query, $membershipId)
    {
        return $query->where('membership_id', $membershipId);
    }

    public function scopeOfProfile($query, $profileId)
    {
        return $query->where('profile_id', $profileId);
    }

    public function canSendMessageTo($receiverProfileId): bool
    {
        // Already sent message to this profile before?
        return Message::where('sender_profile_id', $this->profile_id)
            ->where('receiver_profile_id', $receiverProfileId)
            ->exists();
    }


    /*
    |--------------------------------------------------------------------------
    | AUTO UPDATE: can_user_edit_profile
    |--------------------------------------------------------------------------
    */
    // protected static function booted()
    // {
    //     static::saving(function ($member) {
    //         if ($member->start_date) {
    //             $member->can_user_edit_profile =
    //                 Carbon::parse($member->start_date)->diffInDays(now()) < 7
    //                 ? 'yes'
    //                 : 'no';
    //         }
    //     });
    // }
}
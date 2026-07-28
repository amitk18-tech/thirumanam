<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gender',
        'introduction',
        'dob',
        'age',
        'marital_status',
        'number_of_children',
        'children_living_place',
        'registration_mode',
        'membership_type',
        'day_of_birth',
        'birth_time',
        'paksha',
        'star',
        'rasi',
        'padam',
        'nakshatra',
        'charan',
        'lakknam',
        'horoscope_matching',
        'dosham',
        'type_of_dosham',
        'other_dosham',
        'date_of_birth',
        'tithi',
        'ganam',
        'nadi',
        'directional_balance',
        'birth_place',
        'birth_country',
        'birth_state',
        'birth_city',
        'native_place',
        'country',
        'state',
        'city',
        'address',
        'postal_code',
        'mobile',
        'alternate_number',
        'landline',
        'current_city',
        'height',
        'weight',
        'complexion',
        'body_type',
        'body_art',
        'blood_group',
        'physical_status',
        'eye_color',
        'hair_color',
        'education',
        'occupation',
        'income',
        'work_location',
        'study_details',
        'career_profile',
        'earnings',
        'income_amount',
        'profile_photo',
        'horoscope_file',
        'year',
        'month',
        'day',
    ];

    protected $casts = [
        'verified_by_admin' => 'boolean',
        'blocked_by_admin' => 'boolean',
        'deleted_by_admin' => 'boolean',
    ];

    /* =====================================================
     | BASIC RELATIONSHIPS
     ===================================================== */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function familyDetail()
    {
        return $this->hasOne(FamilyDetail::class);
    }

    public function partnerPreference()
    {
        return $this->hasOne(PartnerPreference::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function member()
    {
        return $this->hasOne(Member::class)->latestOfMany();
    }

    public function horoscopeBoxes()
    {
        return $this->hasMany(HoroscopeBox::class);
    }

    /* =====================================================
     | FOLLOW
     ===================================================== */

    // People who follow this profile
    public function followers()
    {
        return $this->hasMany(ProfileAction::class, 'to_profile_id')
            ->where('action_type', 'follow');
    }

    // Profiles this profile follows
    public function following()
    {
        return $this->hasMany(ProfileAction::class, 'from_profile_id')
            ->where('action_type', 'follow');
    }

    /* =====================================================
     | BLOCK
     ===================================================== */

    // Profiles this profile blocked
    public function blockedProfiles()
    {
        return $this->hasMany(ProfileAction::class, 'from_profile_id')
            ->where('action_type', 'block');
    }

    /* =====================================================
     | SHORTLIST
     ===================================================== */

    // Profiles this profile shortlisted
    public function shortlistedProfiles()
    {
        return $this->hasMany(ProfileAction::class, 'from_profile_id')
            ->where('action_type', 'shortlist');
    }

    /* =====================================================
     | INTERESTS
     ===================================================== */

    // Interests sent by this profile
    public function interestsSent()
    {
        return $this->hasMany(Interest::class, 'sender_profile_id');
    }

    // Interests received by this profile
    public function interestsReceived()
    {
        return $this->hasMany(Interest::class, 'receiver_profile_id');
    }

    /* =====================================================
     | HELPER METHODS (VERY IMPORTANT 🔥)
     ===================================================== */

    // Check interest already sent to another profile
    public function hasSentInterestTo(int $profileId): bool
    {
        return $this->interestsSent()
            ->where('receiver_profile_id', $profileId)
            ->exists();
    }

    // Check follow
    public function isFollowing(int $profileId): bool
    {
        return ProfileAction::where('from_profile_id', $this->id)
            ->where('to_profile_id', $profileId)
            ->where('action_type', 'follow')
            ->exists();
    }

    // Check block
    public function hasBlocked(int $profileId): bool
    {
        return ProfileAction::where('from_profile_id', $this->id)
            ->where('to_profile_id', $profileId)
            ->where('action_type', 'block')
            ->exists();
    }

    // Check shortlist
    public function hasShortlisted(int $profileId): bool
    {
        return ProfileAction::where('from_profile_id', $this->id)
            ->where('to_profile_id', $profileId)
            ->where('action_type', 'shortlist')
            ->exists();
    }


    public function activeMember()
    {
        return $this->hasOne(Member::class)
            ->where('status', 'active')
            ->latestOfMany();
    }
}
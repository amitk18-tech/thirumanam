<?php

namespace App\Models;

use Bits\Package\Models\User as BaseUser;

class User extends BaseUser
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role_id',
        'is_profile_complete',
        'is_active',
        'last_login_at',
    ];

    public function __construct(array $attributes = [])
    {
        // Merge BaseUser fillable dynamically
        $this->fillable = array_merge(
            $this->fillable, // current class fields
            parent::$fillable ?? [] // only if defined as static, otherwise use parent instance
        );

        parent::__construct($attributes);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // In User model
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    // In Profile model
    public function member()
    {
        return $this->hasOne(Member::class);
    }

    public function followers()
{
    return $this->belongsToMany(
        User::class,
        'user_follows',
        'following_id',
        'follower_id'
    );
}

public function following()
{
    return $this->belongsToMany(
        User::class,
        'user_follows',
        'follower_id',
        'following_id'
    );
}

}
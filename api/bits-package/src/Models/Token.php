<?php

namespace Bits\Package\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = 'tokens';

    protected $fillable = [
        'user_id',
        'phone',
        'email',
        'token',
        'type',
        'purpose',
        'expires_at',
        'is_used',
        'meta',
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'expires_at' => 'datetime',
        'meta' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
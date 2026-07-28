<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';

    protected $fillable = [
        'profile_id',
        'type',
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
    ];

    protected $casts = [
        'type' => 'string',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
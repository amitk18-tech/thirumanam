<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'preferred_age_min',
        'preferred_age_max',
        'preferred_height_min',
        'preferred_height_max',
        'age',
        'height',
        'marital_status',
        'children_acceptables',
        'religion',
        'caste',
        'education',
        'occupation',
        'location',
        'horoscope_required',
        'family_type',
        'horoscope_natchathiram',
        'horoscope_rasi',
        'dosham',
        'type_of_dosham',
        'other_dosham',
        'drinking',
        'smoking',
        'eating_habits',
        'about_partner',
        'profession',
        'body_type',
        'expectations',
        'weight',
        'physical_status',
    ];

    protected $casts = [
        'horoscope_required' => 'boolean',
        'horoscope_natchathiram' => 'array', // JSON -> array
    ];

    /**
     * Relationships
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
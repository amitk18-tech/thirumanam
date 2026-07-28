<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AstronomicInformation extends Model
{
    use HasFactory;

    protected $table = 'astronomic_information';

    protected $fillable = [
        'profile_id',
        'star',
        'rasi',
        'nakshatra',
        'charan',
        'padam',
        'ganam',
        'nadi',
        'dosham',
        'type_of_dosham',
        'paksha',
        'tithi',
        'directional_balance',
        'day_of_birth',
        'birth_time',
        'birth_place',
        'birth_country',
        'birth_state',
        'birth_city',
        'lakknam',
        'horoscope_matching',
        'date_of_birth',
        'year',
        'month',
        'day',
    ];

    /**
     * Relationship: AstronomicInformation belongs to Profile
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
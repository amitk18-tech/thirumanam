<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoroscopeBox extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'box_number',
        'item_number',
        'type',
        'value',
    ];

    /**
     * One box has many dropdown values
     */
    public function values()
    {
        return $this->hasMany(HoroscopeBoxValue::class, 'horoscope_box_id');
    }

    /**
     * Optional: If you want relationship with User table
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoroscopeBoxValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'horoscope_box_id',
        'value_type',
        'value',
    ];

    /**
     * Each value belongs to one box
     */
    public function box()
    {
        return $this->belongsTo(HoroscopeBox::class, 'horoscope_box_id');
    }
}

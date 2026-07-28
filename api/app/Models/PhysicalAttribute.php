<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysicalAttribute extends Model
{
    use HasFactory;

    protected $table = 'physical_attributes';

    protected $fillable = [
        'profile_id',
        'height',
        'weight',
        'complexion',
        'body_type',
        'blood_group',
        'physical_status',
        'eye_color',
        'hair_color',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyDetail extends Model
{
    use HasFactory;

    protected $table = 'family_details';

    protected $fillable = [
        'profile_id',
        'surname',
        'father_name',
        'father_occupation',
        'mother_name',
        'mother_occupation',
        'father_vangusam',
        'mother_vangusam',
        'soveran_details',
        'brothers_count',
        'brothers_married',
        'sisters_count',
        'sisters_married',
        'family_status',
        'family_type',
        'family_values',
        'about_family',
        'property_description',
        'property_description_other',
    ];

    protected $casts = [
        'soveran_details' => 'integer',
        'brothers_count' => 'integer',
        'brothers_married' => 'integer',
        'sisters_count' => 'integer',
        'sisters_married' => 'integer',
    ];

    /**
     * Relationships
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}

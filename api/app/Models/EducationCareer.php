<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationCareer extends Model
{
    use HasFactory;

    protected $table = 'education_careers';

    protected $fillable = [
        'profile_id',
        'education',
        'occupation',
        'income',
        'work_location',
        'study_details',
        'career_profile',
        'earnings',
        'income_amount',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
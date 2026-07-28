<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'photo_url',

    ];



    /**
     * Relationships
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function getPhotoUrlAttribute($value)
    {
        if (!$value)
            return null;

        // Returns only the storage path
        return ltrim(Storage::url($value), '/'); // 👈 remove starting slash
    }
}
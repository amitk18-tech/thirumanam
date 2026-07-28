<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeletedMember extends Model
{
    protected $table = 'deleted_members';

    protected $fillable = [
        'member_id',
        'deleted_by',
        'deleted_at',
    ];

    public $timestamps = false;

    /**
     * Relation to Member
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    /**
     * Relation to User/Admin who deleted
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}

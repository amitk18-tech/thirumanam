<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Message extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'sender_profile_id',
        'receiver_profile_id',
        'message_text',
        'message_type',
        'is_read',
    ];
 
    protected $casts = [
        'is_read' => 'boolean',
    ];
 
    /**
     * Relationships
     */

 
    public function senderProfile()
    {
        return $this->belongsTo(Profile::class, 'sender_profile_id');
    }
 
    public function receiverProfile()
    {
        return $this->belongsTo(Profile::class, 'receiver_profile_id');
    }
}
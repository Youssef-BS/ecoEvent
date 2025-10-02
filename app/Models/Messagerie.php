<?php

namespace App\Models;

use App\Enums\MessageStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Messagerie extends Model
{
    use HasFactory;

    protected $fillable = [
        'notification_id',
        'sender_id',
        'receiver_id',
        'content',
        'sent_at',
        'status',
    ];

    protected $casts = [
        'status' => MessageStatus::class,
        'sent_at' => 'datetime',
    ];

    /**
     * Get the notification that owns the messagerie
     */
    public function notification()
    {
        return $this->belongsTo(\App\Models\Notification::class);
    }

    /**
     * Get the sender user
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the receiver user
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}

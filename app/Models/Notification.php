<?php

namespace App\Models;

use App\Enums\NotificationType;
use App\Enums\NotificationStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'title',
        'notification_type',
        'status',
    ];

    protected $casts = [
        'notification_type' => NotificationType::class,
        'status' => NotificationStatus::class,
        'created_at' => 'datetime',
    ];

    /**
     * Get the user that owns the notification
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all messageries for this notification
     */
    public function messageries()
    {
        return $this->hasMany(Messagerie::class);
    }
}

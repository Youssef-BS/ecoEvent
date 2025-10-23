<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'idComplaint';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'type',
        'description',
        'event_id',
        'image',
        'user_id',
        'status',
        'reply',
        'severity',
        'created_at',
    ];


     public function user() {
        return $this->belongsTo(User::class);
    }
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id')->withDefault();
    }
}

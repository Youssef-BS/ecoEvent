<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';
    protected $fillable = [
        'event_id',
        'resource_id',
        'sponsor_id',
        'rating',
        'comment'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }
}

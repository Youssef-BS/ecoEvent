<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'sponsor_id'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = [
        'title',
        'quantity',
        'image',
        'sponsor_id'
    ];

     public function events()
    {
        return $this->belongsToMany(Event::class)
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }
}

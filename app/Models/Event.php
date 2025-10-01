<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'categories',
        'image',
        'date',
        'location',
        'price',
    ];

    protected $casts = [
        'date' => 'datetime',
        'price' => 'integer',
    ];

   public function user() {
        return $this->belongsTo(User::class);
    }

    public function participants() {
        return $this->belongsToMany(User::class, 'participations');
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }
       public function resources() {
        return $this->hasMany(Resource::class);
    }
     public function posts() {
        return $this->hasMany(Post::class);
    }
}

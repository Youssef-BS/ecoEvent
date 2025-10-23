<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany; // Add this import

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'participations');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function resources()
    {
        return $this->belongsToMany(Resource::class)
            ->withPivot('quantity', 'sponsor_id') // ajoute sponsor_id ici
            ->withTimestamps();
    }
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}

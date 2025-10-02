<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    public $fillable = [
        'first_name',
        'last_name',
        'email',
        'image',
        'phone',
        'password',
        'role',
        'bio',
        'location'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
    public function events()
    {
        return $this->hasMany(Event::class);
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

     public function participations() {
        return $this->belongsToMany(Event::class, 'participations');
    }
    public function notifications() {
        return $this->hasMany(Notification::class);
    }
}


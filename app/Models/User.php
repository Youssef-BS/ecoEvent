<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Relationships
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function participations()
    {
        return $this->belongsToMany(Event::class, 'participations');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Profile Accessors
     */

    /**
     * Get user initials for avatar
     */
    public function getInitialsAttribute(): string
    {
        $firstInitial = substr($this->first_name, 0, 1);
        $lastInitial = substr($this->last_name, 0, 1);
        return strtoupper($firstInitial . $lastInitial);
    }

    /**
     * Check if user has a profile image
     */
    public function getHasProfileImageAttribute(): bool
    {
        return !empty($this->image) && Storage::disk('public')->exists($this->image);
    }

    /**
     * Get the full URL for profile image
     */
    public function getProfileImageUrlAttribute(): ?string
    {
        if ($this->has_profile_image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    /**
     * Get full name
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}

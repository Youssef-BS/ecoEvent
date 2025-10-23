<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'image',
        'phone',
        'role',
        'bio',
        'location',


    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
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
     public function participations() {
        return $this->belongsToMany(Event::class, 'participations', 'idUser', 'idEvent')
            ->withPivot(['name', 'email', 'phone'])
            ->withTimestamps();
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

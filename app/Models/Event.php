<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Event extends Model
{
    // Keep fillable aligned with current migration (events table)
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
        // Pivot table uses non-standard keys: idUser, idEvent
        return $this->belongsToMany(User::class, 'participations', 'idEvent', 'idUser')
            ->withPivot(['name', 'email', 'phone'])
            ->withTimestamps();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    // reviews relation already defined above; the duplicate definition was removed.

    // Average rating accessor (returns float or null)
    public function getAverageRatingAttribute(): ?float
    {
        if (!$this->relationLoaded('reviews')) {
            // Avoid triggering N+1 unexpectedly; caller should eager load when needed
            return null;
        }
        $count = $this->reviews->count();
        if ($count === 0) {
            return null;
        }
        return round($this->reviews->avg('rating'), 2);
    }

    // Helper to resolve a raw category string to the configured version (with emoji)
    public static function resolveCategory(string $raw): string
    {
        $rawTrim = trim($raw);
        $all = config('events.categories', []);
        $lowerRaw = mb_strtolower($rawTrim);
        foreach ($all as $c) {
            if (mb_strtolower($c) === $lowerRaw) {
                return $c; // exact match including emoji
            }
            // Strip emojis for comparison of the textual part
            $textOnly = trim(preg_replace('/[\p{So}\p{Cn}]+/u', '', mb_strtolower($c)));
            if ($textOnly === $lowerRaw) {
                return $c;
            }
        }
        return $rawTrim; // fallback (already stored form)
    }

    /**
     * Accessor: Build a public URL for the stored image regardless of how the path was saved.
     * - Supports full http(s) URLs stored directly
     * - Normalizes paths starting with `storage/` or leading slashes
     */
    public function getImageUrlAttribute(): ?string
    {
        $img = (string) ($this->attributes['image'] ?? '');
        if ($img === '') {
            return null;
        }

        $img = Str::of($img)
            ->replace('\\', '/')
            ->ltrim('/');

        // If already an absolute URL, return as is
        if ($img->startsWith(['http://', 'https://'])) {
            return (string) $img;
        }

    // Strip optional leading `storage/` or `public/` if present in DB value
    $path = (string) $img->replaceFirst('storage/', '');
    $path = Str::of($path)->replaceFirst('public/', '');

    // Return a site-relative URL so it works regardless of APP_URL/port
    return '/storage/' . ltrim((string) $path, '/');
    }

    /**
     * Helper: Check if the image file exists on the public disk (when it's a local path).
     */
    public function getHasImageAttribute(): bool
    {
        $img = (string) ($this->attributes['image'] ?? '');
        if ($img === '') {
            return false;
        }

        $img = Str::of($img)
            ->replace('\\', '/')
            ->ltrim('/');

        if ($img->startsWith(['http://', 'https://'])) {
            // Assume externally hosted URLs are valid; blade can still render
            return true;
        }

    $path = (string) $img->replaceFirst('storage/', '');
    $path = Str::of($path)->replaceFirst('public/', '');
    return Storage::disk('public')->exists((string) $path);
    }
}
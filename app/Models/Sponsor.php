<?php

namespace App\Models;

use App\ContributionType;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $fillable = [
        'name',
        'contribution',
        'email',
        'phone',
        'website',
        'logo'
    ];


    // cast automatique vers l'enum PHP
    protected function casts(): array
    {
        return [
            'contribution' => ContributionType::class,
        ];
    }


    public function resources()
    {
        return $this->hasMany(Resource::class);
    }
}

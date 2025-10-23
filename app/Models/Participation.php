<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    protected $table = 'participations';
    protected $fillable = ['idUser', 'idEvent', 'name', 'email', 'phone'];

    public function user() {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function event() {
        return $this->belongsTo(Event::class, 'idEvent');
    }
}

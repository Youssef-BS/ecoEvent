<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
     public function products() {
        return $this->hasMany(Product::class);
    }
}

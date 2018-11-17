<?php

namespace VaccineCard\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function states () {
        return $this->hasMany(State::class);
    }
    
    public function users () {
        return $this->hasMany(User::class);
    }
}

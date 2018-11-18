<?php

namespace VaccineCard\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public function users () {
        return $this->hasMany(User::class);
    }

    public function country () {
        return $this->belongsTo(Country::class);
    }
}

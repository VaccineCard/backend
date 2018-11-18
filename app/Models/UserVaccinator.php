<?php

namespace VaccineCard\Models;

use Illuminate\Database\Eloquent\Model;

class UserVaccinator extends Model
{
    protected $guarded = [];

    public function patients()
    {
        return $this->hasMany(User::class)->where('state', 2);
    }

    public function doctors()
    {
        return $this->hasMany(Vaccinators::class)->where('state', 2);
    }
}

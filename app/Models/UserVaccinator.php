<?php

namespace VaccineCard\Models;

use Illuminate\Database\Eloquent\Model;

class UserVaccinator extends Model
{
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function patients()
    {
        return $this->hasMany(User::class)->where('state', 2)->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function doctors()
    {
        return $this->hasMany(Vaccinators::class)->where('state', 2)->get();
    }
}

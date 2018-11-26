<?php

namespace VaccineCard\Models;

use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(UserVaccine::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function centers()
    {
        return $this->hasMany(VaccineCenter::class, 'vaccine_id');
    }
}

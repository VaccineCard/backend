<?php

namespace VaccineCard\Models;

use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    protected $guarded = [];


    public function users() {
        return $this->hasMany(UserVaccine::class);
    }

    public function centers () {
      return $this->hasMany(VaccineCard::class);
    }
}

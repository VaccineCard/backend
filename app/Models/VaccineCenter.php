<?php

namespace VaccineCard\Models;

use Illuminate\Database\Eloquent\Model;

class VaccineCenter extends Model
{
    protected $table="vaccine_centers";


    public function centers () {
      return $this->hasMany(Center::class);
    }

    public function vaccines () {
      return $this->hasMay(Vaccine::class);
    }

}

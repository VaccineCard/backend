<?php

namespace VaccineCard\Models;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    protected $guarded = [];

    /**
     * @return mixed
     */
    public function vaccines()
    {
        return $this->hasMay(VaccineCenter::class);
    }

}

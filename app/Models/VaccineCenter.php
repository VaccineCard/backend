<?php

namespace VaccineCard\Models;

use Illuminate\Database\Eloquent\Model;

class VaccineCenter extends Model
{
    protected $table = "vaccine_centers";

    protected $guarded = [];

    public function centers($focus)
    {
        return $this->belongsTo(Center::class, 'center_id')->where('focus', $focus)->get();
    }
    public function vaccines()
    {
        return $this->belongsTo(Vaccine::class, 'vaccine_id');
    }
}

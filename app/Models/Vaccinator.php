<?php

namespace VaccineCard\Models;

use Illuminate\Database\Eloquent\Model;

class Vaccinator extends Model
{
    public $guarded = [];

    public function user () {
        return $this->belongsTo(User::class);
    }
}

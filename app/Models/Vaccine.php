<?php

namespace VaccineCard\Models;

use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    protected $table = "vaccines";
    
    protected $fillables = [
        'name', 'expire_at', 'vaccine_code', 'type'
    ];
}

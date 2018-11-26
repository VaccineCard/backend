<?php

namespace VaccineCard\Models;

use Illuminate\Database\Eloquent\Model;

class Vaccinator extends Model
{
    public $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

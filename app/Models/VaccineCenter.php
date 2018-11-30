<?php

namespace VaccineCard\Models;

use Illuminate\Database\Eloquent\Model;

class VaccineCenter extends Model
{
    protected $table = "vaccine_centers";

    protected $guarded = [];

    /**
     * @param $focus
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function centers($focus)
    {
        return $this->belongsTo(Center::class, 'center_id');
    }

    /**
     * @param $category
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function vaccines($category)
    {
        return $this->belongsTo(Vaccine::class, 'vaccine_id')->where('to', $category)->get();
    }
}

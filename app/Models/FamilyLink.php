<?php

namespace VaccineCard\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyLink extends Model
{
    protected $table = "family_links";

    protected $guarded = [];

    protected $hidden = ['user_id'];
}

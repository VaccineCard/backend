<?php

namespace VaccineCard\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'birth',
        'state_id', 'country_id', 'phone', 'gender',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function vaccinator()
    {
        return $this->hasOne(Vaccinator::class);
    }

    public function family_sender () {
        return $this->hasMany(FamilyLink::class, 'user_id');
    }

    public function family_recive () {
        return $this->hasMany(FamilyLink::class, 'family_id')->where('state', 2 );
    }

    public function families()
    {
        return $this->family_sender()->union($this->family_recive()->toBase());
    }
}
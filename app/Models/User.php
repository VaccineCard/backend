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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vaccinator()
    {
        return $this->hasOne(Vaccinator::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function family_sender()
    {
        return $this->hasMany(FamilyLink::class, 'user_id');
    }

    /**
     * @return $this
     */
    public function family_recive()
    {
        return $this->hasMany(FamilyLink::class, 'family_id')->where('state', 2);
    }

    /**
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function families()
    {
        return $this->family_sender()->union($this->family_recive()->toBase());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vaccines()
    {
        return $this->hasMany(UserVaccine::class);
    }
}

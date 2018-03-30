<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class RadiusUser extends Model
{
    use Uuids;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'forename', 'surname', 'email', 'username', 'password', 'suspended'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'suspended', 'username'
    ];

    /**
     * Get the confirmation for the user.
     */
    public function confirm()
    {
        return $this->hasOne('App\Models\RadiusConfirm');
    }
}
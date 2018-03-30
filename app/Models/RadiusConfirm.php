<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;


class RadiusConfirm extends Model
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
        'hash', 'completed'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'hash', 'completed', 'user_id'
    ];

    /**
     * Get the user that owns the confirmation.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\RadiusUser', 'radius_user_id', 'id');
    }
}
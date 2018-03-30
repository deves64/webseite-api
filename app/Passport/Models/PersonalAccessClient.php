<?php

namespace App\Passport\Models;

use Laravel\Passport\PersonalAccessClient as PassportPersonalAccessClient;

class PersonalAccessClient extends PassportPersonalAccessClient
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'laravel_website';

    /**
     * Get all of the authentication codes for the client.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
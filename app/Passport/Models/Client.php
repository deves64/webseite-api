<?php

namespace App\Passport\Models;

use Laravel\Passport\Client as PassportClient;

class Client extends PassportClient
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'laravel_website';
}
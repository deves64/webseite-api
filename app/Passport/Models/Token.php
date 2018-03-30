<?php

namespace App\Passport\Models;

use Laravel\Passport\Token as PassportToken;

class Token extends PassportToken
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'laravel_website';
}
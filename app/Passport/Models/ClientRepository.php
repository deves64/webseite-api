<?php

namespace App\Passport\Models;

use Laravel\Passport\ClientRepository as PassportClientRepository;

class ClientRepository extends PassportClientRepository
{
    /**
     * Get a client by the given ID.
     *
     * @param  int  $id
     * @return \Laravel\Passport\Client|null
     */
    public function find($id)
    {
        return Client::find($id);
    }

    /**
     * Store a new client.
     *
     * @param  int  $userId
     * @param  string  $name
     * @param  string  $redirect
     * @param  bool  $personalAccess
     * @param  bool  $password
     * @return \Laravel\Passport\Client
     */
    public function create($userId, $name, $redirect, $personalAccess = false, $password = false)
    {
        $client = (new Client)->forceFill([
            'user_id' => $userId,
            'name' => $name,
            'secret' => str_random(40),
            'redirect' => $redirect,
            'personal_access_client' => $personalAccess,
            'password_client' => $password,
            'revoked' => false,
        ]);

        $client->save();

        return $client;
    }
}
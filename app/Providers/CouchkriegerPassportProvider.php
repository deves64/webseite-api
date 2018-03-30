<?php

namespace App\Providers;

use App\Passport\Models\ClientRepository;
use App\Passport\Models\TokenRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Bridge\AuthCodeRepository as BridgeAuthCodeRepository;
use Illuminate\Database\Connection;
use Laravel\Passport\ClientRepository as PassportClientRepository;
use Laravel\Passport\TokenRepository as PassportTokenRepository;
use Laravel\Passport\Bridge\RefreshTokenRepository as BridgeRefreshTokenRepository;

class CouchkriegerPassportProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PassportTokenRepository::class, function ($app) {
            return new TokenRepository();
        });

        $this->app->singleton(PassportClientRepository::class, function ($app) {
            return new ClientRepository();
        });

        $this->app->when(BridgeAuthCodeRepository::class)
                  ->needs(Connection::class)
                  ->give(function () {
                        return DB::connection('laravel_website');
                  });

        $this->app->when(BridgeRefreshTokenRepository::class)
                  ->needs(Connection::class)
                  ->give(function () {
                        return DB::connection('laravel_website');
                  });
    }
}
<?php

namespace App\Providers;

use App\Models\Message;
use App\Policies\MessagePolicy;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {

        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->hasHeader('Authorization')) {
                return User::where('api_token', $request->header('Authorization'))->first();
            }

//            return User::find('2dab4e80-2b81-11e8-ab04-51151db1447e');
        });

        Gate::policy(Message::class, MessagePolicy::class);
    }
}

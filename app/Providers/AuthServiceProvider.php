<?php

namespace App\Providers;

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
            if ($request->header('apiToken')) {
                $decodedRequest = json_decode(base64_decode($request->header('apiToken')), true);
                $email = $decodedRequest['email'];
                $password = $decodedRequest['password'];
                $user = User::where('email', $email)->where('password', $password)->first();
                if($user == null) return null;
                if($request->input('user_id') && json_decode($user, true)['user_id'] != $request->input('user_id')) return null;
                return $user;
            }
            else return null;
        });
    }
}

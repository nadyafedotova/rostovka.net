<?php

namespace App\Providers;

use App\Client;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {

        Validator::extend('valid_email', function ($attribute, $value){
            if(User::where('email', '=', $value)->first())
            return false;
            else return true;

        },'Email is already exist in Data Base');

        Validator::extend('valid_phone', function ($attribute, $value){
            if(User::where('phone', '=', $value)->first())
            return false;
            else return true;

        },'Phone is already exist in Data Base');

        $this->registerPolicies();

        //
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidationProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('zip_validation', function ($attribute, $value){;

            if($value != 'undefined') {
                if ($value->extension() == 'zip')
                    return true;
                else return false;
            }
            else return true;

        },'Only zip file');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

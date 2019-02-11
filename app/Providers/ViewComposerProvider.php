<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('user.markup.header', 'App\Http\Controllers\HomeController@categories');

        view()->composer('user.category_page.filters', 'App\Http\Controllers\FilterController@getFiltersValues');

        view()->composer('user.filters.filters', 'App\Http\Controllers\FilterController@getFiltersValues');

        view()->composer('user.brands.filters', 'App\Http\Controllers\FilterController@getBrandValues');
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

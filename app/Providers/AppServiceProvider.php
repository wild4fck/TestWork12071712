<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Validator::extend('keysExists', function ($attribute, $value, $parameters, $validator) {
            return $parameters[0]::whereIn($parameters[1], array_keys($value))->count() === count(array_keys($value));
        });
    }
}

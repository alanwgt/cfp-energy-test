<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Password::defaults(function () {
            $rules = Password::min(8);

            return $this->app->isProduction()
                ? $rules->uncompromised()
                : $rules;
        });
    }
}

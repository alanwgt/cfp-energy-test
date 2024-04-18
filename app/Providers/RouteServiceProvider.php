<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            /** @var ?User $user */
            $user = $request->user();

            return Limit::perMinute(60)->by($user?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->name('api.v1.')
                ->prefix('api/v1')
                ->group(base_path('routes/apiV1.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}

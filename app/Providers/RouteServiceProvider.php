<?php

namespace App\Providers;

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
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        // Rate limiter untuk API
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Rate limiter untuk password reset
        RateLimiter::for('password-reset', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip());
        });

        // Rate limiter untuk forgot password - check username
        // Membatasi 5 percobaan per menit untuk mencegah enumerasi username
        RateLimiter::for('forgot-password-check', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // Rate limiter untuk forgot password - email verification (Mentor)
        // Membatasi 3 percobaan per 5 menit untuk mencegah spam email
        RateLimiter::for('forgot-password-email', function (Request $request) {
            return Limit::perMinutes(5, 3)->by($request->ip());
        });

        // Rate limiter global untuk routes sensitif
        RateLimiter::for('auth-attempts', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip())->response(function () {
                return back()->withErrors([
                    'throttle' => 'Terlalu banyak percobaan dari IP Anda. Silakan tunggu beberapa saat.'
                ]);
            });
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}

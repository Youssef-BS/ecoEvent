<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            // Routes client
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            // Routes admin protégées et préfixées
            Route::middleware(['web', 'auth', 'is_admin'])
                ->prefix('admin')
                ->group(base_path('routes/admin.php'));

            // Routes API
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }
}

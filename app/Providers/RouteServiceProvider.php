<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckPermission;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Route::middleware('web')
            ->middleware([
                'check.permissao' => CheckPermission::class,
            ])
            ->group(base_path('routes/web.php'));
    }
}

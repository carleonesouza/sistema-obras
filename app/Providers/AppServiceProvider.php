<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        // if (env('APP_ENV') == 'production') {
        //     $url->forceScheme('https');
        // }
        if (env('APP_DEBUG')) {
            DB::listen(function ($query) {
                Log::info($query->sql, $query->bindings);
            });
        }
        
    }
}

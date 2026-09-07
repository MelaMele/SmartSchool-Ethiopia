<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Paginator::useTailwind();

        // በ Vercel እና በ Production ላይ ሁልጊዜ በ HTTPS (የተጠበቀ መስመር) ብቻ እንዲሰራ ማስገደድ
        if (config('app.env') === 'production' || isset($_ENV['VERCEL']) || isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            URL::forceScheme('https');
        }
    }
}

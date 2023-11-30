<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    // //ローカル用
    // public function boot(): void
    // {
    //     $this->app['request']->server->set('HTTP','on');
    //     if(\App::environment(['production'])||\App::environment(['develop'])){
    //         \URL::forceScheme('http');
    //     }
    // }

    public function boot(): void
    {
        $this->app['request']->server->set('HTTPS','on');
        if(\App::environment(['production'])||\App::environment(['develop'])){
            \URL::forceScheme('https');
        }
    }
}

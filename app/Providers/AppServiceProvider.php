<?php

namespace App\Providers;

use Auth;
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
    public function boot()
    {
        // 用来自定义guard 认证驱动
        //Auth::provider('custom', static function ($app, $config) {
        //    return new CustomEloquentUserProvider($app['hash'], $config['model']);
        //});
    }
}

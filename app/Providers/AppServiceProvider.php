<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 打印sql语句
        // \DB::listen(function($query) { 
        //         echo $query->sql;
        //         echo '<br/>';
        //         print_r( $query->bindings);
        //         echo '<br/>';
        //     });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HertzServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'hertz',
            function ( $app ) {
                return new \App\Services\HertzService();
            }
        );

        $this->app->booting(
            function() {
                $loader = \Illuminate\Foundation\AliasLoader::getInstance();
                $loader->alias( 'HertzService', 'App\Services\HertzService' );
            }
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

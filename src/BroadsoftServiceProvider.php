<?php

namespace jvleeuwen\broadsoft;

use Illuminate\Support\ServiceProvider;


class BroadsoftServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/Routes/routes.php';
        $this->loadViewsFrom(__DIR__.'/Views', 'broadsoft');
        $this->publishes([__DIR__.'/Config/pusher.php' => config_path('pusher.php'),]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('jvleeuwen\broadsoft\BroadsoftController');
        $this->app->make('jvleeuwen\broadsoft\CallCenterAgentController');
        $this->app->make('jvleeuwen\broadsoft\AdvancedCallController');
        $this->app->make('jvleeuwen\broadsoft\Controllers\ExampleController');
        // $this->app->register('Vinkla\Pusher\PusherServiceProvider');

        // $loader = \Illuminate\Foundation\AliasLoader::getInstance();
    }
}

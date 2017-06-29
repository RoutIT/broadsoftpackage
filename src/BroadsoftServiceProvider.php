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
        $this->publishes([
            __DIR__.'/Assets/js/broadsoft.js' => base_path('resources/assets/js/broadsoft.js'),
            __DIR__.'/Assets/js/components/CallCenterQueue.vue' => base_path('resources/assets/js/components/CallCenterQueue.js'),
            __DIR__.'/Assets/js/components/CallCenterAgents.vue' => base_path('resources/assets/js/components/CallCenterAgents.vue'),
            __DIR__.'/Assets/js/components/AdvancedCall.vue' => base_path('resources/assets/js/components/AdvancedCall.vue'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('jvleeuwen\broadsoft\CallCenterAgentController');
        $this->app->make('jvleeuwen\broadsoft\CallCenterQueueController');
        $this->app->make('jvleeuwen\broadsoft\AdvancedCallController');
        $this->app->make('jvleeuwen\broadsoft\Controllers\DebugController');
    }
}

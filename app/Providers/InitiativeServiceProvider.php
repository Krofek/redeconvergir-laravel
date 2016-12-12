<?php

namespace App\Providers;

use App\Interfaces\InitiativeRepositoryInterface;
use App\Repositories\InitiativeRepository;
use App\Services\EventService;
use App\Services\InitiativeService;
use Illuminate\Support\ServiceProvider;

class InitiativeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Interfaces\InitiativeRepositoryInterface', 'App\Repositories\InitiativeRepository');

        $this->app->singleton(InitiativeService::class);
        $this->app->singleton(EventService::class);

    }

//    /**
//     * Get the services provided by the provider.
//     *
//     * @return array
//     */
//    public function provides()
//    {
//        return [InitiativeService::class];
//    }
}

<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\Initiative;
use App\Policies\EventPolicy;
use App\Policies\InitiativePolicy;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Initiative::class => InitiativePolicy::class,
        Event::class => EventPolicy::class
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}

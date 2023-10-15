<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Src\BoundedContext\Auth\Infrastructure\Providers\DomainAuthProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Auth::provider('domain', function (Application $app, array $config) {
            return app()->make(DomainAuthProvider::class);
        });
    }
}

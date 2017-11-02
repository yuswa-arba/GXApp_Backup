<?php

namespace App\Providers;

use App\Http\Controllers\Auth\EloquentAdminUserProvider;
use App\Http\Controllers\Auth\EloquentSuperAdminUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Binding eloquent.admin to our EloquentAdminUserProvider
        Auth::provider('eloquent.admin', function($app, array $config) {
            return new EloquentAdminUserProvider($app['hash'], $config['model']);
        });

        // Binding eloquent.superAdmin to our EloquentAdminUserProvider
        Auth::provider('eloquent.superAdmin', function($app, array $config) {
            return new EloquentSuperAdminUserProvider($app['hash'], $config['model']);
        });
    }
}

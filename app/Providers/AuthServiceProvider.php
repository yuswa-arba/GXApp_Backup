<?php

namespace App\Providers;

use App\Employee\Models\MasterEmployee;
use App\Http\Controllers\Auth\EloquentAdminUserProvider;
use App\Http\Controllers\Auth\EloquentSuperAdminUserProvider;
use App\Policies\EmployeePolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Log;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
//        'App\Model' => 'App\Policies\ModelPolicy',
        MasterEmployee::class => EmployeePolicy::class
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
        Auth::provider('eloquent.admin', function ($app, array $config) {
            return new EloquentAdminUserProvider($app['hash'], $config['model']);
        });


        // Binding eloquent.superAdmin to our EloquentAdminUserProvider
        Auth::provider('eloquent.superAdmin', function ($app, array $config) {
            return new EloquentSuperAdminUserProvider($app['hash'], $config['model']);
        });
    }
}

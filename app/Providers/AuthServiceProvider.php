<?php

namespace heychum\Providers;

use App\Policies\TaskPolicy;
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
        'heychum\Model' => 'heychum\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // the gate checks if the user is an admin or a superadmin
        Gate::define('accessAdminpanel', function($user) {
            return $user->role(['admin', 'staff']);
        });

        // the gate checks if the user is a member
        Gate::define('accessMember', function($user) {
            return $user->role('member');
        });

    }
}

<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\User' => 'App\Policies\UserPolicy',
        'App\Specialty' => 'App\Policies\SpecialtyPolicy',
        'App\Tag' => 'App\Policies\TagPolicy',
        'App\Doctor' => 'App\Policies\DoctorPolicy',
        'App\Document' => 'App\Policies\DocumentPolicy',
        'App\Workplace' => 'App\Policies\WorkplacePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isDoctor', function($user){
            return $user->isDoctor();
        });

        Gate::define('isAdmin', function($user){
            return $user->acl == '1';
        });

        Gate::define('isStaff', function($user){
            return $user->acl == '2';
        });

        Gate::define('isSuperAdmin', function($user){
            return $user->acl == '5';
        });

        Gate::define('isOwner', function($user){//isContentOwner
            return $user->id === $this->user_id;
        });

        Passport::routes();
    }
}

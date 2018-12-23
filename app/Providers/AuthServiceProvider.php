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

        'App\Application'   => 'App\Policies\ApplicationPolicy',
        'App\Appointment'   => 'App\Policies\AppointmentPolicy',
        'App\Doctor'        => 'App\Policies\DoctorPolicy',
        'App\Document'      => 'App\Policies\DocumentPolicy',
        'App\Drug'          => 'App\Policies\DrugPolicy',
        // 'App\Image'      => 'App\Policies\ImagePolicy',
        'App\Message'       => 'App\Policies\MessagePolicy',
        'App\Prescription'  => 'App\Policies\PrescriptionPolicy',
        'App\Review'        => 'App\Policies\ReviewPolicy',
        'App\Schedule'      => 'App\Policies\SchedulePolicy',
        'App\Specialty'     => 'App\Policies\SpecialtyPolicy',
        'App\Tag'           => 'App\Policies\TagPolicy',
        'App\User'          => 'App\Policies\UserPolicy',
        'App\Workplace'     => 'App\Policies\WorkplacePolicy',
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
            return $user->isDoctor() || $user->isSuperAdmin();
        });

        Gate::define('isAdmin', function($user){
            return $user->isAdmin();
        });

        Gate::define('isStaff', function($user){
            return $user->isStaff();
        });

        Gate::define('isSuperAdmin', function($user){
            return $user->isSuperAdmin();
        });

        Gate::define('isOwner', function($user){//isContentOwner
            return $user->id === $this->user_id;
        });

        Passport::routes();
    }
}

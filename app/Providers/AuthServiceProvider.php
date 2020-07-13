<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Modules\Gate\Entities\Company;
use Modules\Gate\Entities\Role;
use Modules\Gate\Entities\RoleMenu;
use Modules\Gate\Entities\User;
use Modules\Gate\Policies\CompanyPolicy;
use Modules\Gate\Policies\RoleMenuPolicy;
use Modules\Gate\Policies\RolePolicy;
use Modules\Gate\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
//        'App\Model' => 'App\Policies\ModelPolicy',
        Company::class => CompanyPolicy::class,
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
        RoleMenu::class => RoleMenuPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//        Gate::resource('company', CompanyPolicy::class);
    }
}

<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Modules\Examples\Entities\Example;
use Modules\Examples\Policies\ExamplePolicy;
use Modules\Gate\Entities\Company;
use Modules\Gate\Entities\Role;
use Modules\Gate\Entities\RoleMenu;
use Modules\Gate\Entities\User;
use Modules\Gate\Policies\CompanyPolicy;
use Modules\Gate\Policies\RoleMenuPolicy;
use Modules\Gate\Policies\RolePolicy;
use Modules\Gate\Policies\UserPolicy;
use Modules\HumanResources\Entities\OrganizationStructure;
use Modules\HumanResources\Entities\OrganizationStructureTitle;
use Modules\HumanResources\Policies\OrganizationStructurePolicy;
use Modules\HumanResources\Policies\OrganizationStructureTitlePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Company::class => CompanyPolicy::class,
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
        RoleMenu::class => RoleMenuPolicy::class,
        Example::class => ExamplePolicy::class,
        OrganizationStructure::class => OrganizationStructurePolicy::class,
        OrganizationStructureTitle::class => OrganizationStructureTitlePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//        Gate::before(function ($user, $ability) {
//            $queryRoleMenu = RoleMenu::where(
//                'role_id', Auth::user()->role_id
//            )->whereHas('role', function($role){
//                    $role->where('status', 1);
//                })->first();
//
//            if ($queryRoleMenu == null){
//                return false;
//            } else {
//                return true;
//            }
//        });
    }
}

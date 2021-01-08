<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Modules\Examples\Entities\Example;
use Modules\Examples\Policies\ExamplePolicy;
use Modules\Gate\Entities\Company;
use Modules\Gate\Entities\Menu;
use Modules\Gate\Entities\Role;
use Modules\Gate\Entities\RoleMenu;
use Modules\Gate\Entities\User;
use Modules\Gate\Policies\CompanyPolicy;
use Modules\Gate\Policies\MenuPolicy;
use Modules\Gate\Policies\RoleMenuPolicy;
use Modules\Gate\Policies\RolePolicy;
use Modules\Gate\Policies\UserPolicy;
use Modules\HumanResources\Entities\Address;
use Modules\HumanResources\Entities\Attendance;
use Modules\HumanResources\Entities\Education;
use Modules\HumanResources\Entities\Employee;
use Modules\HumanResources\Entities\Family;
use Modules\HumanResources\Entities\Holiday;
use Modules\HumanResources\Entities\IdCard;
use Modules\HumanResources\Entities\LeaveQuota;
use Modules\HumanResources\Entities\OrganizationStructure;
use Modules\HumanResources\Entities\OrganizationStructureTitle;
use Modules\HumanResources\Entities\Request;
use Modules\HumanResources\Entities\WorkingGroup;
use Modules\HumanResources\Entities\WorkingGroupDetail;
use Modules\HumanResources\Entities\WorkingHour;
use Modules\HumanResources\Entities\WorkingHourAttendance;
use Modules\HumanResources\Entities\WorkingHourDetail;
use Modules\HumanResources\Policies\AddressPolicy;
use Modules\HumanResources\Policies\AttendancePolicy;
use Modules\HumanResources\Policies\EducationPolicy;
use Modules\HumanResources\Policies\EmployeePolicy;
use Modules\HumanResources\Policies\FamilyPolicy;
use Modules\HumanResources\Policies\HolidayPolicy;
use Modules\HumanResources\Policies\IdCardPolicy;
use Modules\HumanResources\Policies\LeaveQuotaPolicy;
use Modules\HumanResources\Policies\OrganizationStructurePolicy;
use Modules\HumanResources\Policies\OrganizationStructureTitlePolicy;
use Modules\HumanResources\Policies\RequestPolicy;
use Modules\HumanResources\Policies\WorkingGroupDetailPolicy;
use Modules\HumanResources\Policies\WorkingGroupPolicy;
use Modules\HumanResources\Policies\WorkingHourAttendancePolicy;
use Modules\HumanResources\Policies\WorkingHourDetailPolicy;
use Modules\HumanResources\Policies\WorkingHourPolicy;

use Modules\PPC\Policies\TaskcardTypePolicy;
use Modules\PPC\Entities\TaskcardType;

use Modules\QualityAssurance\Policies\SkillPolicy;
use Modules\QualityAssurance\Entities\Skill;

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
        Menu::class => MenuPolicy::class,
        RoleMenu::class => RoleMenuPolicy::class,

        Example::class => ExamplePolicy::class,
        
        OrganizationStructure::class => OrganizationStructurePolicy::class,
        OrganizationStructureTitle::class => OrganizationStructureTitlePolicy::class,
        WorkingGroup::class => WorkingGroupPolicy::class,
        WorkingGroupDetail::class => WorkingGroupDetailPolicy::class,
        Holiday::class => HolidayPolicy::class,
        Employee::class => EmployeePolicy::class,
        IdCard::class => IdCardPolicy::class,
        Education::class => EducationPolicy::class,
        Family::class => FamilyPolicy::class,
        Address::class => AddressPolicy::class,
        WorkingHour::class => WorkingHourPolicy::class,
        WorkingHourDetail::class => WorkingHourDetailPolicy::class,
        WorkingHourAttendance::class => WorkingHourAttendancePolicy::class,
        Attendance::class => AttendancePolicy::class,
        LeaveQuota::class => LeaveQuotaPolicy::class,
        Request::class => RequestPolicy::class,

        TaskcardType::class => TaskcardTypePolicy::class,
        
        Skill::class => SkillPolicy::class,
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

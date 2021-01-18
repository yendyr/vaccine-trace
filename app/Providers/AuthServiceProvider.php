<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use Modules\Examples\Entities\Example;
use Modules\Examples\Policies\ExamplePolicy;

use Modules\Gate\Entities\Menu;
use Modules\Gate\Entities\Role;
use Modules\Gate\Entities\RoleMenu;
use Modules\Gate\Entities\User;

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

use Modules\PPC\Policies\TaskcardGroupPolicy;
use Modules\PPC\Entities\TaskcardGroup;

use Modules\PPC\Policies\TaskcardWorkareaPolicy;
use Modules\PPC\Entities\TaskcardWorkarea;

use Modules\PPC\Policies\TaskcardAccessPolicy;
use Modules\PPC\Entities\TaskcardAccess;

use Modules\PPC\Policies\TaskcardZonePolicy;
use Modules\PPC\Entities\TaskcardZone;

use Modules\PPC\Policies\TaskcardDocumentLibraryPolicy;
use Modules\PPC\Entities\TaskcardDocumentLibrary;

use Modules\PPC\Policies\TaskcardPolicy;
use Modules\PPC\Entities\Taskcard;

use Modules\PPC\Policies\AircraftTypePolicy;
use Modules\PPC\Entities\AircraftType;

use Modules\QualityAssurance\Policies\SkillPolicy;
use Modules\QualityAssurance\Entities\Skill;

use Modules\QualityAssurance\Policies\DocumentTypePolicy;
use Modules\QualityAssurance\Entities\DocumentType;

use Modules\QualityAssurance\Policies\EngineeringLevelPolicy;
use Modules\QualityAssurance\Entities\EngineeringLevel;

use Modules\QualityAssurance\Policies\TaskReleaseLevelPolicy;
use Modules\QualityAssurance\Entities\TaskReleaseLevel;

use Modules\GeneralSetting\Policies\CountryPolicy;
use Modules\GeneralSetting\Entities\Country;

use Modules\GeneralSetting\Policies\CompanyPolicy;
use Modules\GeneralSetting\Entities\Company;

use Modules\GeneralSetting\Policies\CompanyDetailContactPolicy;
use Modules\GeneralSetting\Entities\CompanyDetailContact;

use Modules\GeneralSetting\Policies\CompanyDetailAddressPolicy;
use Modules\GeneralSetting\Entities\CompanyDetailAddress;

use Modules\GeneralSetting\Policies\AirportPolicy;
use Modules\GeneralSetting\Entities\Airport;

use Modules\SupplyChain\Policies\WarehousePolicy;
use Modules\SupplyChain\Entities\Warehouse;

use Modules\SupplyChain\Policies\UnitClassPolicy;
use Modules\SupplyChain\Entities\UnitClass;

use Modules\SupplyChain\Policies\UnitPolicy;
use Modules\SupplyChain\Entities\Unit;

use Modules\SupplyChain\Policies\ItemCategoryPolicy;
use Modules\SupplyChain\Entities\ItemCategory;

use Modules\SupplyChain\Policies\ItemPolicy;
use Modules\SupplyChain\Entities\Item;

use Modules\Accounting\Policies\ChartOfAccountClassPolicy;
use Modules\Accounting\Entities\ChartOfAccountClass;

use Modules\Accounting\Policies\ChartOfAccountPolicy;
use Modules\Accounting\Entities\ChartOfAccount;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
        Menu::class => MenuPolicy::class,
        RoleMenu::class => RoleMenuPolicy::class,
        
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
        TaskcardGroup::class => TaskcardGroupPolicy::class,
        TaskcardWorkarea::class => TaskcardWorkareaPolicy::class,
        TaskcardAccess::class => TaskcardAccessPolicy::class,
        TaskcardZone::class => TaskcardZonePolicy::class,
        TaskcardDocumentLibrary::class => TaskcardDocumentLibraryPolicy::class,
        Taskcard::class => TaskcardPolicy::class,
        AircraftType::class => AircraftTypePolicy::class,
        
        Skill::class => SkillPolicy::class,
        DocumentType::class => DocumentTypePolicy::class,
        EngineeringLevel::class => EngineeringLevelPolicy::class,
        TaskReleaseLevel::class => TaskReleaseLevelPolicy::class,

        Company::class => CompanyPolicy::class,
        CompanyDetailContact::class => CompanyDetailContactPolicy::class,
        CompanyDetailAddress::class => CompanyDetailAddressPolicy::class,
        Country::class => CountryPolicy::class,
        Airport::class => AirportPolicy::class,

        Warehouse::class => WarehousePolicy::class,
        UnitClass::class => UnitClassPolicy::class,
        Unit::class => UnitPolicy::class,
        ItemCategory::class => ItemCategoryPolicy::class,
        Item::class => ItemPolicy::class,

        ChartOfAccountClass::class => ChartOfAccountClassPolicy::class,
        ChartOfAccount::class => ChartOfAccountPolicy::class,
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

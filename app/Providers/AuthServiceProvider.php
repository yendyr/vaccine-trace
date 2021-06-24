<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Illuminate\Support\Facades\Gate;

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

use Modules\PPC\Policies\TaskcardTagPolicy;
use Modules\PPC\Entities\TaskcardTag;

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

use Modules\PPC\Policies\TaskcardDetailInstructionPolicy;
use Modules\PPC\Entities\TaskcardDetailInstruction;

use Modules\PPC\Policies\TaskcardDetailItemPolicy;
use Modules\PPC\Entities\TaskcardDetailItem;

use Modules\PPC\Policies\AircraftTypePolicy;
use Modules\PPC\Entities\AircraftType;

use Modules\PPC\Policies\MaintenanceProgramPolicy;
use Modules\PPC\Entities\MaintenanceProgram;

use Modules\PPC\Policies\MaintenanceProgramDetailPolicy;
use Modules\PPC\Entities\MaintenanceProgramDetail;

use Modules\PPC\Policies\AircraftConfigurationTemplatePolicy;
use Modules\PPC\Entities\AircraftConfigurationTemplate;

use Modules\PPC\Policies\AircraftConfigurationTemplateDetailPolicy;
use Modules\PPC\Entities\AircraftConfigurationTemplateDetail;

use Modules\PPC\Policies\AircraftConfigurationPolicy;
use Modules\PPC\Entities\AircraftConfiguration;

use Modules\PPC\Policies\ItemStockAgingPolicy;
use Modules\PPC\Entities\ItemStockAging;

use Modules\PPC\Policies\MaintenanceStatusPolicy;
use Modules\PPC\Entities\MaintenanceStatus;

use Modules\PPC\Policies\WorkOrderPolicy;
use Modules\PPC\Entities\WorkOrder;

use Modules\PPC\Policies\AircraftAgingPolicy;

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

use Modules\GeneralSetting\Policies\CompanyDetailBankPolicy;
use Modules\GeneralSetting\Entities\CompanyDetailBank;

use Modules\GeneralSetting\Policies\AirportPolicy;
use Modules\GeneralSetting\Entities\Airport;

use Modules\GeneralSetting\Policies\CurrencyPolicy;
use Modules\GeneralSetting\Entities\Currency;

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

use Modules\SupplyChain\Policies\StockMutationInboundPolicy;
use Modules\SupplyChain\Policies\StockMutationOutboundPolicy;
use Modules\SupplyChain\Policies\StockMutationTransferPolicy;
use Modules\SupplyChain\Entities\StockMutation;

use Modules\SupplyChain\Policies\ItemStockPolicy;
use Modules\SupplyChain\Entities\ItemStock;

use Modules\Accounting\Policies\ChartOfAccountClassPolicy;
use Modules\Accounting\Entities\ChartOfAccountClass;

use Modules\Accounting\Policies\ChartOfAccountPolicy;
use Modules\Accounting\Entities\ChartOfAccount;

use Modules\Accounting\Policies\JournalPolicy;
use Modules\Accounting\Entities\Journal;

use Modules\Accounting\Policies\TrialBalancePolicy;
use Modules\Accounting\Entities\TrialBalance;

use Modules\Accounting\Policies\GeneralLedgerPolicy;
use Modules\Accounting\Entities\GeneralLedger;

use Modules\Accounting\Policies\ProfitLossPolicy;
use Modules\Accounting\Entities\ProfitLoss;

use Modules\FlightOperations\Policies\AfmLogPolicy;
use Modules\FlightOperations\Entities\AfmLog;

use Modules\FlightOperations\Policies\AfmlDetailCrewPolicy;
use Modules\FlightOperations\Entities\AfmlDetailCrew;

use Modules\FlightOperations\Policies\AfmlDetailJournalPolicy;
use Modules\FlightOperations\Entities\AfmlDetailJournal;

use Modules\FlightOperations\Policies\AfmlDetailManifestPolicy;
use Modules\FlightOperations\Entities\AfmlDetailManifest;

use Modules\FlightOperations\Policies\AfmlDetailDiscrepancyPolicy;
use Modules\FlightOperations\Entities\AfmlDetailDiscrepancy;

use Modules\FlightOperations\Policies\AfmlDetailRectificationPolicy;
use Modules\FlightOperations\Entities\AfmlDetailRectification;

use Modules\PPC\Entities\WorkOrderWorkPackage;
use Modules\PPC\Policies\WorkOrderWorkPackagePolicy;

use Modules\PPC\Entities\WorkOrderWorkPackageTaskcard;
use Modules\PPC\Policies\WorkOrderWorkPackageTaskcardPolicy;

use Modules\PPC\Entities\WOWPTaskcardDetail;
use Modules\PPC\Policies\WOWPTaskcardDetailPolicy;

use Modules\PPC\Entities\WOWPTaskcardDetailItem;
use Modules\PPC\Policies\WOWPTaskcardDetailItemPolicy;

use Modules\PPC\Entities\WOWPTaskcardDetailProgress;
use Modules\PPC\Policies\WOWPTaskcardDetailProgressPolicy;

use Modules\Procurement\Entities\PurchaseRequisition;
use Modules\Procurement\Policies\PurchaseRequisitionPolicy;

use Modules\Procurement\Entities\PurchaseOrder;
use Modules\Procurement\Policies\PurchaseOrderPolicy;

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
        TaskcardTag::class => TaskcardTagPolicy::class,
        TaskcardWorkarea::class => TaskcardWorkareaPolicy::class,
        TaskcardAccess::class => TaskcardAccessPolicy::class,
        TaskcardZone::class => TaskcardZonePolicy::class,
        TaskcardDocumentLibrary::class => TaskcardDocumentLibraryPolicy::class,
        Taskcard::class => TaskcardPolicy::class,
        TaskcardDetailInstruction::class => TaskcardDetailInstructionPolicy::class,
        TaskcardDetailItem::class => TaskcardDetailItemPolicy::class,
        AircraftType::class => AircraftTypePolicy::class,
        MaintenanceProgram::class => MaintenanceProgramPolicy::class,
        // MaintenanceProgram::class => MaintenanceStatusPolicy::class,
        MaintenanceProgramDetail::class => MaintenanceProgramDetailPolicy::class,
        AircraftConfigurationTemplate::class => AircraftConfigurationTemplatePolicy::class,
        AircraftConfigurationTemplateDetail::class => AircraftConfigurationTemplateDetailPolicy::class,
        AircraftConfiguration::class => AircraftConfigurationPolicy::class,
        ItemStockAging::class => ItemStockAgingPolicy::class,
        ItemStockAging::class => AircraftAgingPolicy::class,

        WorkOrder::class => WorkOrderPolicy::class,
        WorkOrderWorkPackage::class => WorkOrderWorkPackagePolicy::class,
        WorkOrderWorkPackageTaskcard::class => WorkOrderWorkPackageTaskcardPolicy::class,
        WOWPTaskcardDetail::class => WOWPTaskcardDetailPolicy::class,
        WOWPTaskcardDetailItem::class => WOWPTaskcardDetailItemPolicy::class,
        WOWPTaskcardDetailProgress::class => WOWPTaskcardDetailProgressPolicy::class,

        Skill::class => SkillPolicy::class,
        DocumentType::class => DocumentTypePolicy::class,
        EngineeringLevel::class => EngineeringLevelPolicy::class,
        TaskReleaseLevel::class => TaskReleaseLevelPolicy::class,

        Company::class => CompanyPolicy::class,
        CompanyDetailContact::class => CompanyDetailContactPolicy::class,
        CompanyDetailAddress::class => CompanyDetailAddressPolicy::class,
        CompanyDetailBank::class => CompanyDetailBankPolicy::class,
        Country::class => CountryPolicy::class,
        Airport::class => AirportPolicy::class,
        Currency::class => CurrencyPolicy::class,

        Warehouse::class => WarehousePolicy::class,
        UnitClass::class => UnitClassPolicy::class,
        Unit::class => UnitPolicy::class,
        ItemCategory::class => ItemCategoryPolicy::class,
        Item::class => ItemPolicy::class,
        StockMutation::class => StockMutationInboundPolicy::class,
        // StockMutation::class => StockMutationOutboundPolicy::class,
        // StockMutation::class => StockMutationTransferPolicy::class,
        ItemStock::class => ItemStockPolicy::class,

        ChartOfAccountClass::class => ChartOfAccountClassPolicy::class,
        ChartOfAccount::class => ChartOfAccountPolicy::class,
        Journal::class => JournalPolicy::class,
        TrialBalance::class => TrialBalancePolicy::class,
        GeneralLedger::class => GeneralLedgerPolicy::class,
        ProfitLoss::class => ProfitLossPolicy::class,

        AfmLog::class => AfmLogPolicy::class,
        AfmlDetailCrew::class => AfmlDetailCrewPolicy::class,
        AfmlDetailJournal::class => AfmlDetailJournalPolicy::class,
        AfmlDetailManifest::class => AfmlDetailManifestPolicy::class,
        AfmlDetailDiscrepancy::class => AfmlDetailDiscrepancyPolicy::class,
        AfmlDetailRectification::class => AfmlDetailRectificationPolicy::class,

        PurchaseRequisition::class => PurchaseRequisitionPolicy::class,
        PurchaseOrder::class => PurchaseOrderPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::before(function ($user, $ability) {
        //     dump($user);
        //     dd($ability);
        // });
    }
}

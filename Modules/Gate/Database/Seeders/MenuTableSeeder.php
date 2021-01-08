<?php

namespace Modules\Gate\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Menu;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $toolsMenu = Menu::create([
            'menu_link' => '#',
            'menu_text' => 'Tools',
            'menu_route' => null,
            'menu_icon' => 'fa-wrench',
            'menu_class' => null,
            'menu_id' => null,
            'group' => 'Gate',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        $menu = Menu::create([
            'menu_link' => 'gate/user',
            'menu_text' => 'User',
            'menu_route' => 'gate.user.index',
            'menu_icon' => 'fa-user-circle-o',
            'menu_class' => 'Modules\Gate\Entities\User',
            'menu_id' => 'gate',
            'menu_actives' => json_encode(['gate/user', 'gate/user/*']),
            'group' => 'Gate',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $toolsMenu->id
        ]);
        
        $menu = Menu::create([
            'menu_link' => 'gate/company',
            'menu_text' => 'Company',
            'menu_route' => 'gate.company.index',
            'menu_icon' => 'fa-building-o',
            'menu_class' => 'Modules\Gate\Entities\Company',
            'menu_id' => null,
            'menu_actives' => json_encode(['gate/company', 'gate/company/*']),
            'group' => 'Gate',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $toolsMenu->id
        ]);
        
        $menu = Menu::create([
            'menu_link' => 'gate/role',
            'menu_text' => 'Role',
            'menu_route' => 'gate.role.index',
            'menu_icon' => 'fa-users',
            'menu_class' => 'Modules\Gate\Entities\Role',
            'menu_id' => null,
            'menu_actives' => json_encode(['gate/role', 'gate/role/*']),
            'group' => 'Gate',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $toolsMenu->id
        ]);
        
        $menu = Menu::create([
            'menu_link' => 'gate/menu',
            'menu_text' => 'Menu',
            'menu_route' => 'gate.menu.index',
            'menu_icon' => 'fa-list-alt',
            'menu_class' => 'Modules\Gate\Entities\Menu',
            'menu_id' => null,
            'menu_actives' => json_encode(['gate/menu', 'gate/menu/*']),
            'group' => 'Gate',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $toolsMenu->id
        ]);
        
        $menu = Menu::create([
            'menu_link' => 'gate/role-menu',
            'menu_text' => 'Role-menu',
            'menu_route' => 'gate.role-menu.index',
            'menu_icon' => 'fa-list-alt',
            'menu_class' => 'Modules\Gate\Entities\RoleMenu',
            'menu_id' => null,
            'menu_actives' => json_encode(['gate/role-menu', 'gate/role-menu/*']),
            'group' => 'Gate',
            'add' => 1,
            'update' => 0,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $toolsMenu->id
        ]);
        
        $menu = Menu::create([
            'menu_link' => 'examples/example',
            'menu_text' => 'Example',
            'menu_route' => 'examples.example.index',
            'menu_icon' => 'fa fa-plus',
            'menu_class' => 'Modules\Gate\Entities\Example',
            'menu_id' => null,
            'menu_actives' => json_encode(['examples/example', 'examples/example/*']),
            'group' => 'Examples',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 7,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        $menuHrSetting = Menu::create([
            'menu_link' => '#',
            'menu_text' => 'Setting',
            'menu_route' => null,
            'menu_icon' => 'fa-wrench',
            'menu_class' => null,
            'menu_id' => null,
            'group' => 'Human Resources',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);

        $menu = Menu::create([
            'menu_link' => 'hr/org-structure',
            'menu_text' => 'Organization Structure',
            'menu_route' => 'hr.org-structure.index',
            'menu_icon' => 'fa-user-circle-o',
            'menu_class' => 'Modules\HumanResources\Entities\OrganizationStructure',
            'menu_id' => null,
            'menu_actives' => json_encode(['hr/org-structure', 'hr/org-structure/*']),
            'group' => 'Human Resources',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuHrSetting->id
        ]);
        
        $menu = Menu::create([
            'menu_link' => 'hr/org-structure-title',
            'menu_text' => 'Organization Structure Title',
            'menu_route' => 'hr.user.index',
            'menu_icon' => 'fa-user-circle-o',
            'menu_class' => 'Modules\HumanResources\Entities\User',
            'menu_id' => 'gate',
            'menu_actives' => json_encode(['hr/org-structure-title', 'hr/org-structure-title/*']),
            'group' => 'Human Resources',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        $workGroupMenu = Menu::create([
            'menu_link' => 'hr/working-group',
            'menu_text' => 'Working Group',
            'menu_route' => 'hr.workgroup.index',
            'menu_icon' => 'fa-minus',
            'menu_class' => 'Modules\HumanResources\Entities\WorkingGroup',
            'menu_id' => null,
            'menu_actives' => json_encode(['hr/workgroup', 'hr/workgroup/*']),
            'group' => 'Human Resources',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuHrSetting->id
        ]);
        
        $menu = Menu::create([
            'menu_link' => 'hr/working-group-detail',
            'menu_text' => 'Working Group Detail',
            'menu_route' => 'hr.workgroup-detail.index',
            'menu_icon' => 'fa-plus',
            'menu_class' => 'Modules\HumanResources\Entities\WorkingGroupDetail',
            'menu_id' => null,
            'menu_actives' => json_encode(['hr/working-group-detail', 'hr/working-group-detail/*']),
            'group' => 'Human Resources',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $workGroupMenu->id
        ]);
        
        $menu = Menu::create([
            'menu_link' => 'hr/holiday',
            'menu_text' => 'Holiday',
            'menu_route' => 'hr.holiday.index',
            'menu_icon' => 'fa-minus',
            'menu_class' => 'Modules\HumanResources\Entities\Holiday',
            'menu_id' => null,
            'menu_actives' => json_encode(['hr/holiday', 'hr/holiday/*']),
            'group' => 'Human Resources',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuHrSetting->id
        ]);

        $menu = Menu::create([
            'menu_link' => 'hr/employee',
            'menu_text' => 'Employee',
            'menu_route' => 'hr.employee.index',
            'menu_icon' => 'fa-plus',
            'menu_class' => 'Modules\HumanResources\Entities\Employee',
            'menu_id' => null,
            'menu_actives' => json_encode(['hr/employee', 'hr/employee/*']),
            'group' => 'Human Resources',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        $menu = Menu::create([
            'menu_link' => 'hr/id-card',
            'menu_text' => 'ID Card',
            'menu_route' => 'hr.id-card.index',
            'menu_icon' => 'fa-plus',
            'menu_class' => 'Modules\HumanResources\Entities\idCard',
            'menu_id' => null,
            'menu_actives' => json_encode(['hr/id-card', 'hr/id-card/*']),
            'group' => 'Human Resources',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        $menu = Menu::create([
            'menu_link' => 'hr/education',
            'menu_text' => 'Education',
            'menu_route' => 'hr.education.index',
            'menu_icon' => 'fa-plus',
            'menu_class' => 'Modules\HumanResources\Entities\Education',
            'menu_id' => null,
            'menu_actives' => json_encode(['hr/education', 'hr/education/*']),
            'group' => 'Human Resources',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        $menu = Menu::create([
            'menu_link' => 'hr/family',
            'menu_text' => 'Family',
            'menu_route' => 'hr.family.index',
            'menu_icon' => 'fa-plus',
            'menu_class' => 'Modules\HumanResources\Entities\Family',
            'menu_id' => null,
            'menu_actives' => json_encode(['hr/family', 'hr/family/*']),
            'group' => 'Human Resources',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        $menu = Menu::create([
            'menu_link' => 'hr/address',
            'menu_text' => 'Address',
            'menu_route' => 'hr.address.index',
            'menu_icon' => 'fa-plus',
            'menu_class' => 'Modules\HumanResources\Entities\Address',
            'menu_id' => null,
            'menu_actives' => json_encode(['hr/address', 'hr/address/*']),
            'group' => 'Human Resources',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        $menu = Menu::create([
            'menu_link' => 'hr/working-hour',
            'menu_text' => 'Working Hour',
            'menu_route' => 'hr.working-hour.index',
            'menu_icon' => 'fa-plus',
            'menu_class' => 'Modules\HumanResources\Entities\WorkingHour',
            'menu_id' => null,
            'menu_actives' => json_encode(['hr/working-hour', 'hr/working-hour/*']),
            'group' => 'Human Resources',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        $menu = Menu::create([
            'menu_link' => 'hr/working-hour-detail',
            'menu_text' => 'Working Hour detail',
            'menu_route' => 'hr.working-hour-detail.index',
            'menu_icon' => 'fa-plus',
            'menu_class' => 'Modules\HumanResources\Entities\WorkingHourDetail',
            'menu_id' => null,
            'menu_actives' => json_encode(['hr/working-hour-detail', 'hr/working-hour-detail/*']),
            'group' => 'Human Resources',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        $menu = Menu::create([
            'menu_link' => 'hr/working-hour-attendance',
            'menu_text' => 'Working Hour attendance',
            'menu_route' => 'hr.working-hour-attendance.index',
            'menu_icon' => 'fa-plus',
            'menu_class' => 'Modules\HumanResources\Entities\WorkingHourAttendance',
            'menu_id' => null,
            'menu_actives' => json_encode(['hr/working-hour-attendance', 'hr/working-hour-attendance/*']),
            'group' => 'Human Resources',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        $menu = Menu::create([
            'menu_link' => 'hr/attendance',
            'menu_text' => 'Attendance',
            'menu_route' => 'hr.attendance.index',
            'menu_icon' => 'fa-plus',
            'menu_class' => 'Modules\HumanResources\Entities\Attendance',
            'menu_id' => null,
            'menu_actives' => json_encode(['hr/attendance', 'hr/attendance/*']),
            'group' => 'Human Resources',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        $menu = Menu::create([
            'menu_link' => 'hr/leave-quota',
            'menu_text' => 'Leave Quota',
            'menu_route' => 'hr.leave-quota.index',
            'menu_icon' => 'fa-plus',
            'menu_class' => 'Modules\HumanResources\Entities\LeaveQuota',
            'menu_id' => null,
            'menu_actives' => json_encode(['hr/leave-quota', 'hr/leave-quota/*']),
            'group' => 'Human Resources',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        $menu = Menu::create([
            'menu_link' => 'hr/request',
            'menu_text' => 'Request',
            'menu_route' => 'hr.request.index',
            'menu_icon' => 'fa-plus',
            'menu_class' => 'Modules\HumanResources\Entities\Request',
            'menu_id' => null,
            'menu_actives' => json_encode(['hr/request', 'hr/request/*']),
            'group' => 'Human Resources',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 0,
            'approval' => 5,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);

        // ----------- Create PPC Module Menus ------------------------//
        $menuPpcTaskcard = Menu::create([
            'menu_link' => '#',
            'menu_text' => 'Task Card',
            'menu_route' => null,
            'menu_icon' => 'fa-sitemap',
            'menu_class' => null,
            'menu_id' => null,
            'group' => 'PPC',
            'add' => 0,
            'update' => 0,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);

        $menu = Menu::create([
            'menu_link' => '#',
            'menu_text' => 'Master Task Card Group',
            'menu_route' => null,
            'menu_icon' => 'fa-chain-broken',
            'menu_class' => null,
            'menu_id' => null,
            'menu_actives' => json_encode(['ppc/taskcard/group', 'ppc/taskcard/group/*']),
            'group' => 'PPC',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuPpcTaskcard->id
        ]);

        $menu = Menu::create([
            'menu_link' => 'ppc/taskcard/type',
            'menu_text' => 'Master Task Card Type',
            'menu_route' => 'ppc.taskcard.type.index',
            'menu_icon' => 'fa-columns',
            'menu_class' => 'Modules\PPC\Entities\TaskcardType',
            'menu_id' => null,
            'menu_actives' => json_encode(['ppc/taskcard/type', 'ppc/taskcard/type/*']),
            'group' => 'PPC',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuPpcTaskcard->id
        ]);

        $menu = Menu::create([
            'menu_link' => '#',
            'menu_text' => 'Master Task Card Work Area',
            'menu_route' => null,
            'menu_icon' => 'fa-yelp',
            'menu_class' => null,
            'menu_id' => null,
            'menu_actives' => json_encode(['ppc/taskcard/workarea', 'ppc/taskcard/workarea/*']),
            'group' => 'PPC',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuPpcTaskcard->id
        ]);

        $menu = Menu::create([
            'menu_link' => '#',
            'menu_text' => 'Master Task Card Access',
            'menu_route' => null,
            'menu_icon' => 'fa-circle-o-notch',
            'menu_class' => null,
            'menu_id' => null,
            'menu_actives' => json_encode(['ppc/taskcard/access', 'ppc/taskcard/access/*']),
            'group' => 'PPC',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuPpcTaskcard->id
        ]);

        $menu = Menu::create([
            'menu_link' => '#',
            'menu_text' => 'Master Task Card Zone',
            'menu_route' => null,
            'menu_icon' => 'fa-slack',
            'menu_class' => null,
            'menu_id' => null,
            'menu_actives' => json_encode(['ppc/taskcard/zone', 'ppc/taskcard/zone/*']),
            'group' => 'PPC',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuPpcTaskcard->id
        ]);

        $menu = Menu::create([
            'menu_link' => '#',
            'menu_text' => 'Master Task Card Document Library',
            'menu_route' => null,
            'menu_icon' => 'fa-folder',
            'menu_class' => null,
            'menu_id' => null,
            'menu_actives' => json_encode(['ppc/taskcard/document-library', 'ppc/taskcard/document-library/*']),
            'group' => 'PPC',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuPpcTaskcard->id
        ]);

        $menu = Menu::create([
            'menu_link' => 'ppc/taskcard',
            'menu_text' => 'Master Task Card',
            'menu_route' => null,
            'menu_icon' => 'fa-clipboard',
            'menu_class' => 'Modules\PPC\Entities\Taskcard',
            'menu_id' => null,
            'menu_actives' => json_encode(['ppc/taskcard', 'ppc/taskcard/*']),
            'group' => 'PPC',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuPpcTaskcard->id
        ]);
        // ----------- END Create PPC Module Menus ------------------------//

        // ----------- Create Quality Module Menus ------------------------//
        $menu = Menu::create([
            'menu_link' => 'qualityassurance/skill',
            'menu_text' => 'Master Skill',
            'menu_route' => null,
            'menu_icon' => 'fa-bookmark',
            'menu_class' => 'Modules\QualityAssurance\Entities\Skill',
            'menu_id' => null,
            'menu_actives' => json_encode(['qualityassurance/skill', 'qualityassurance/skill/*']),
            'group' => 'Quality Assurance',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);

        $menu = Menu::create([
            'menu_link' => 'qualityassurance/skill-level',
            'menu_text' => 'Master Skill Leveling',
            'menu_route' => null,
            'menu_icon' => 'fa-signal',
            'menu_class' => 'Modules\QualityAssurance\Entities\SkillLevel',
            'menu_id' => null,
            'menu_actives' => json_encode(['qualityassurance/skill-level', 'qualityassurance/skill-level/*']),
            'group' => 'Quality Assurance',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);

        $menu = Menu::create([
            'menu_link' => 'qualityassurance/document-type',
            'menu_text' => 'Master Document Type',
            'menu_route' => null,
            'menu_icon' => 'fa-tags',
            'menu_class' => 'Modules\QualityAssurance\Entities\DocumentType',
            'menu_id' => null,
            'menu_actives' => json_encode(['qualityassurance/document-type', 'qualityassurance/document-type/*']),
            'group' => 'Quality Assurance',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        // ----------- END Create Quality Module Menus ------------------------//
    }
}

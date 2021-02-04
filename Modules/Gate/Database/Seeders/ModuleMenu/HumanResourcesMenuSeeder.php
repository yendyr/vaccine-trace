<?php

namespace Modules\Gate\Database\Seeders\ModuleMenu;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Menu;

class HumanResourcesMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

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
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);

        Menu::create([
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
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuHrSetting->id
        ]);
        
        Menu::create([
            'menu_link' => 'hr/org-structure-title',
            'menu_text' => 'Organization Structure Title',
            'menu_route' => 'hr.user.index',
            'menu_icon' => 'fa-user-circle-o',
            'menu_class' => 'Modules\HumanResources\Entities\User',
            'menu_id' => null,
            'menu_actives' => json_encode(['hr/org-structure-title', 'hr/org-structure-title/*']),
            'group' => 'Human Resources',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
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
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuHrSetting->id
        ]);
        
        Menu::create([
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
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $workGroupMenu->id
        ]);
        
        Menu::create([
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
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuHrSetting->id
        ]);

        Menu::create([
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
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        Menu::create([
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
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        Menu::create([
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
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        Menu::create([
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
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        Menu::create([
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
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        Menu::create([
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
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        Menu::create([
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
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        Menu::create([
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
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        Menu::create([
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
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        Menu::create([
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
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        Menu::create([
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
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
    }
}
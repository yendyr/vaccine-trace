<?php

namespace Modules\PPC\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use Modules\Gate\Entities\RoleMenu;
use Modules\PPC\Entities\WorkOrder;

class WorkOrderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function viewAny()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'ppc/work-order')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return true;
        }
    }

    public function view()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'ppc/work-order')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return true;
        }
    }

    public function create()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'ppc/work-order')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return $queryRoleMenu->add == 1;
        }
    }

    public function update(WorkOrder $work_order)
    {
        if($work_order->approvals->count() != 0) {
            return false;
        }

        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'ppc/work-order')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return $queryRoleMenu->update == 1;
        }
    }

    public function approval(WorkOrder $work_order)
    {
        if($work_order->approvals->count() != 0) {
            return false;
        }

        $queryRoleMenu = RoleMenu::where('role_id', Auth::user()->role_id)->where('menu_link', 'ppc/work-order')->whereHas('role', function($role){$role->where('status', 1);})->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return json_decode($queryRoleMenu->approval, true) != 0;
        }
    }

    public function delete(WorkOrder $work_order)
    {
        if($work_order->approvals->count() != 0) {
            return false;
        }

        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'ppc/work-order')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return $queryRoleMenu->delete == 1;
        }
    }

    public function forceDelete(WorkOrder $work_order)
    {
        if($work_order->approvals->count() != 0) {
            return false;
        }

        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'ppc/work-order')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return $queryRoleMenu->delete == 1;
        }
    }
}

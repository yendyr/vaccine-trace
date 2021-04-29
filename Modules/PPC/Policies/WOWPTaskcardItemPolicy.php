<?php

namespace Modules\PPC\Policies;


use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Gate\Entities\RoleMenu;
use Modules\PPC\Entities\WorkOrder;

class WOWPTaskcardItemPolicy
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

    public function viewAny(User $user)
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', $user->role_id
        )->where('menu_link', 'ppc/work-order')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return true;
        }
    }

    public function view(User $user)
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', $user->role_id
        )->where('menu_link', 'ppc/work-order')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return true;
        }
    }

    public function create(User $user)
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', $user->role_id
        )->where('menu_link', 'ppc/work-order')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return $queryRoleMenu->add == 1;
        }
    }

    public function update(User $user, WorkOrder $work_order)
    {
        if($work_order->approvals->count() !== 0) {
            return false;
        }

        $queryRoleMenu = RoleMenu::where(
            'role_id', $user->role_id
        )->where('menu_link', 'ppc/work-order')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return $queryRoleMenu->update == 1;
        }
    }

    public function approval(User $user, WorkOrder $work_order)
    {
        if($work_order->approvals->count() !== 0) {
            return false;
        }

        $queryRoleMenu = RoleMenu::where('role_id', $user->role_id)->where('menu_link', 'ppc/work-order')->whereHas('role', function($role){$role->where('status', 1);})->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return json_decode($queryRoleMenu->approval, true) !== 0;
        }
    }

    public function delete(User $user, WorkOrder $work_order)
    {
        if($work_order->approvals->count() !== 0) {
            return false;
        }

        $queryRoleMenu = RoleMenu::where(
            'role_id', $user->role_id
        )->where('menu_link', 'ppc/work-order')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return $queryRoleMenu->delete == 1;
        }
    }

    public function forceDelete(User $user, WorkOrder $work_order)
    {
        if($work_order->approvals->count() !== 0) {
            return false;
        }

        $queryRoleMenu = RoleMenu::where(
            'role_id', $user->role_id
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

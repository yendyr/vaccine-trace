<?php

namespace Modules\PPC\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Gate\Entities\RoleMenu;
use Modules\PPC\Entities\WorkOrder;
use Modules\PPC\Entities\WorkOrderWorkPackage;
use Modules\PPC\Entities\WorkOrderWorkPackageTaskcard;

class WorkOrderWorkPackageTaskcardPolicy
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
        )->where('menu_link', 'ppc/job-card')->whereHas('role', function($role){
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
        )->where('menu_link', 'ppc/job-card')->whereHas('role', function($role){
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
        )->where('menu_link', 'ppc/job-card')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return $queryRoleMenu->process == 1;
        }
    }

    public function update(User $user, WorkOrderWorkPackageTaskcard $job_card)
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', $user->role_id
        )->where('menu_link', 'ppc/job-card')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return $queryRoleMenu->update == 1;
        }
    }

    public function approval(User $user, WorkOrderWorkPackageTaskcard $job_card)
    {
        $queryRoleMenu = RoleMenu::where('role_id', $user->role_id)->where('menu_link', 'ppc/job-card')->whereHas('role', function($role){$role->where('status', 1);})->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return json_decode($queryRoleMenu->approval, true) !== 0;
        }
    }

    public function delete(User $user, WorkOrderWorkPackageTaskcard $job_card)
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', $user->role_id
        )->where('menu_link', 'ppc/job-card')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return $queryRoleMenu->delete == 1;
        }
    }

    public function forceDelete(User $user, WorkOrderWorkPackageTaskcard $job_card)
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', $user->role_id
        )->where('menu_link', 'ppc/job-card')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return $queryRoleMenu->delete == 1;
        }
    }
}

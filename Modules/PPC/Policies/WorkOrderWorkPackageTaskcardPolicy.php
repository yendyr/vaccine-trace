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

    public function create(User $user, WorkOrder $work_order)
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

    public function execute(User $user, WorkOrderWorkPackageTaskcard $job_card)
    {
        if( $job_card->type != array_search('job-card', config('ppc.job-card.type')) ) {
            return false;
        }

        $is_open = false;
        
        if( $job_card->transaction_status == array_search('open', config('ppc.job-card.transaction-status')) 
        || $job_card->transaction_status == array_search('progress', config('ppc.job-card.transaction-status')) 
        || $job_card->transaction_status == array_search('partially progress', config('ppc.job-card.transaction-status')) 
        || $job_card->transaction_status == array_search('pending', config('ppc.job-card.transaction-status')) )
        {
            $is_open = true;   
        }

        if(!$is_open) {
            return false;
        }

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

    public function release(User $user, WorkOrderWorkPackageTaskcard $job_card)
    {
        if( $job_card->type != array_search('job-card', config('ppc.job-card.type')) ) {
            return false;
        }

        $is_open = false;
        
        if( $job_card->transaction_status == array_search('partially closed', config('ppc.job-card.transaction-status')) 
        || $job_card->transaction_status == array_search('closed', config('ppc.job-card.transaction-status')) )
        {
            $is_open = true;   
        }

        if(!$is_open) {
            return false;
        }

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
}

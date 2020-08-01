<?php

namespace Modules\HumanResources\Policies;

use Illuminate\Support\Facades\Auth;
use Modules\Gate\Entities\RoleMenu;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationStructurePolicy
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

    /**
     * Determine whether the user can view any org-structures.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'hr/org-structure')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return true;
        }
    }

    /**
     * Determine whether the user can create org-structures.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'hr/org-structure')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return $queryRoleMenu->add == 1;
        }
    }

    /**
     * Determine whether the user can update the org-structure.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $org-structure
     * @return mixed
     */
    public function update()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'hr/org-structure')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return $queryRoleMenu->update == 1;
        }
    }

    /**
     * Determine whether the user can delete the org-structure.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $org-structure
     * @return mixed
     */
    public function delete()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'hr/org-structure')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return $queryRoleMenu->delete == 1;
        }
    }

    /**
     * Determine whether the user can permanently delete the org-structure.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $org-structure
     * @return mixed
     */
    public function forceDelete()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'hr/org-structure')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return $queryRoleMenu->delete == 1;
        }
    }

}

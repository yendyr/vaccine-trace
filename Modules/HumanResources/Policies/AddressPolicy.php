<?php

namespace Modules\HumanResources\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use Modules\Gate\Entities\RoleMenu;

class AddressPolicy
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
     * Determine whether the user can view any address.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'hr/address')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return true;
        }
    }

    /**
     * Determine whether the user can create address.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'hr/address')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return $queryRoleMenu->add == 1;
        }
    }

    /**
     * Determine whether the user can update the address.
     *
     * @param  \App\User  $user
     * @param  \App\Holiday  $address
     * @return mixed
     */
    public function update()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'hr/address')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return $queryRoleMenu->update == 1;
        }
    }

    /**
     * Determine whether the user can delete the address.
     *
     * @param  \App\User  $user
     * @param  \App\Holiday  $address
     * @return mixed
     */
    public function delete()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'hr/address')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return $queryRoleMenu->delete == 1;
        }
    }

    /**
     * Determine whether the user can permanently delete the address.
     *
     * @param  \App\User  $user
     * @param  \App\Holiday  $address
     * @return mixed
     */
    public function forceDelete()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'hr/address')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return $queryRoleMenu->delete == 1;
        }
    }
}

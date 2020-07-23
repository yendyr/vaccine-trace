<?php

namespace Modules\Gate\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Gate\Entities\RoleMenu;
use Modules\Gate\Entities\User;

class RoleMenuPolicy
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

    public function before()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return true;
        }
    }

    /**
     * Determine whether the user can view any role menus.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'gate/role-menu')->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return true;
        }
    }

    /**
     * Determine whether the user can view the role menu.
     *
     * @param  \App\User  $user
     * @param  \App\RoleMenu  $roleMenu
     * @return mixed
     */
    public function view()
    {
        //
    }

    /**
     * Determine whether the user can create role menus.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'gate/role-menu')->first();

        return $queryRoleMenu->add == 1;
    }

    /**
     * Determine whether the user can update the role menu.
     *
     * @param  \App\User  $user
     * @param  \App\RoleMenu  $roleMenu
     * @return mixed
     */
    public function update()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'gate/role-menu')->first();

        return $queryRoleMenu->update == 1;
    }

    /**
     * Determine whether the user can delete the role menu.
     *
     * @param  \App\User  $user
     * @param  \App\RoleMenu  $roleMenu
     * @return mixed
     */
    public function delete()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'gate/role-menu')->first();

        return $queryRoleMenu->delete == 1;
    }

    /**
     * Determine whether the user can restore the role menu.
     *
     * @param  \App\User  $user
     * @param  \App\RoleMenu  $roleMenu
     * @return mixed
     */
    public function restore(User $user, RoleMenu $roleMenu)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the role menu.
     *
     * @param  \App\User  $user
     * @param  \App\RoleMenu  $roleMenu
     * @return mixed
     */
    public function forceDelete()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'gate/role-menu')->first();

        return $queryRoleMenu->delete == 1;
    }
}

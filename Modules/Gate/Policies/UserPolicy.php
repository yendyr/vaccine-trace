<?php

namespace Modules\Gate\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Gate\Entities\RoleMenu;
use Modules\Gate\Entities\User;

class UserPolicy
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
     * Determine whether the user can view any roles.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny()
    {
        $role_menu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'gate/user')->first();

        if ($role_menu == null){
            return false;
        } else {
            return true;
        }
    }

    /**
     * Determine whether the user can view the role.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function view()
    {
        //
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create()
    {
        $role_menu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'gate/user')->first();

        return $role_menu->add == 1;
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function update()
    {
        $role_menu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'gate/user')->first();

        return $role_menu->edit == 1;
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete()
    {
        $role_menu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'gate/user')->first();

        return $role_menu->delete == 1;
    }

    /**
     * Determine whether the user can restore the role.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function restore(User $user, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the role.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function forceDelete()
    {
        $role_menu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'gate/user')->first();

        return $role_menu->delete == 1;
    }
}

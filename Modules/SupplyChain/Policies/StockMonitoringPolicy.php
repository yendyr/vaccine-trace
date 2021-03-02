<?php

namespace Modules\SupplyChain\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use Modules\Gate\Entities\RoleMenu;

class StockMonitoringPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        
    }

    public function viewAny()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'supplychain/stock-monitoring')->whereHas('role', function($role){
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
        )->where('menu_link', 'supplychain/stock-monitoring')->whereHas('role', function($role){
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
        )->where('menu_link', 'supplychain/stock-monitoring')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return $queryRoleMenu->add == 1;
        }
    }

    public function update()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'supplychain/stock-monitoring')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return $queryRoleMenu->update == 1;
        }
    }

    public function approval()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'supplychain/stock-monitoring')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return json_decode($queryRoleMenu->approval, true) != 0;
        }
    }

    public function delete()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'supplychain/stock-monitoring')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return $queryRoleMenu->delete == 1;
        }
    }

    public function forceDelete()
    {
        $queryRoleMenu = RoleMenu::where(
            'role_id', Auth::user()->role_id
        )->where('menu_link', 'supplychain/stock-monitoring')->whereHas('role', function($role){
            $role->where('status', 1);
        })->first();

        if ($queryRoleMenu == null){
            return false;
        } else {
            return $queryRoleMenu->delete == 1;
        }
    }
}
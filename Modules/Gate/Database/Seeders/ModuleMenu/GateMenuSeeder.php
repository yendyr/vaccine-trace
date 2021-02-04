<?php

namespace Modules\Gate\Database\Seeders\ModuleMenu;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Menu;

class GateMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        
        Menu::create([
            'menu_link' => '#',
            'menu_text' => 'Tools',
            'menu_route' => null,
            'menu_icon' => 'fa-wrench',
            'menu_class' => null,
            'menu_id' => null,
            'group' => 'Gate',
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
            'menu_link' => 'gate/user',
            'menu_text' => 'User',
            'menu_route' => 'gate.user.index',
            'menu_icon' => 'fa-user-circle-o',
            'menu_class' => 'Modules\Gate\Entities\User',
            'menu_id' => 'gate',
            'menu_actives' => json_encode(['gate/user', 'gate/user/*']),
            'group' => 'Gate',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $toolsMenu->id
        ]);
        
        Menu::create([
            'menu_link' => 'gate/role',
            'menu_text' => 'Role',
            'menu_route' => 'gate.role.index',
            'menu_icon' => 'fa-users',
            'menu_class' => 'Modules\Gate\Entities\Role',
            'menu_id' => null,
            'menu_actives' => json_encode(['gate/role', 'gate/role/*']),
            'group' => 'Gate',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $toolsMenu->id
        ]);
        
        Menu::create([
            'menu_link' => 'gate/menu',
            'menu_text' => 'Menu',
            'menu_route' => 'gate.menu.index',
            'menu_icon' => 'fa-list-alt',
            'menu_class' => 'Modules\Gate\Entities\Menu',
            'menu_id' => null,
            'menu_actives' => json_encode(['gate/menu', 'gate/menu/*']),
            'group' => 'Gate',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $toolsMenu->id
        ]);
        
        Menu::create([
            'menu_link' => 'gate/role-menu',
            'menu_text' => 'Role-menu',
            'menu_route' => 'gate.role-menu.index',
            'menu_icon' => 'fa-list-alt',
            'menu_class' => 'Modules\Gate\Entities\RoleMenu',
            'menu_id' => null,
            'menu_actives' => json_encode(['gate/role-menu', 'gate/role-menu/*']),
            'group' => 'Gate',
            'add' => 1,
            'update' => 0,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $toolsMenu->id
        ]);
    }
}
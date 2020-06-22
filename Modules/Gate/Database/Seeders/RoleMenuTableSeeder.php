<?php

namespace Modules\Gate\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Gate\Entities\RoleMenu;

class RoleMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $rolemenu = RoleMenu::create([
            'menu_id' => 1,
            'role_id' => 1,
            'menu_link' => 'gate/user',
            'add' => 1,
            'edit' => 1,
            'delete' => 1,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $rolemenu = RoleMenu::create([
            'menu_id' => 2,
            'role_id' => 1,
            'menu_link' => 'gate/company',
            'add' => 1,
            'edit' => 1,
            'delete' => 1,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $rolemenu = RoleMenu::create([
            'menu_id' => 3,
            'role_id' => 1,
            'menu_link' => 'gate/role',
            'add' => 1,
            'edit' => 1,
            'delete' => 1,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $rolemenu = RoleMenu::create([
            'menu_id' => 4,
            'role_id' => 1,
            'menu_link' => 'gate/role-menu',
            'add' => 1,
            'edit' => 1,
            'delete' => 1,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);

        $rolemenu = RoleMenu::create([
            'menu_id' => 1,
            'role_id' => 2,
            'menu_link' => 'gate/user',
            'add' => 0,
            'edit' => 0,
            'delete' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $rolemenu = RoleMenu::create([
            'menu_id' => 2,
            'role_id' => 2,
            'menu_link' => 'gate/company',
            'add' => 0,
            'edit' => 0,
            'delete' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $rolemenu = RoleMenu::create([
            'menu_id' => 3,
            'role_id' => 2,
            'menu_link' => 'gate/role',
            'add' => 0,
            'edit' => 0,
            'delete' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $rolemenu = RoleMenu::create([
            'menu_id' => 4,
            'role_id' => 2,
            'menu_link' => 'gate/role-menu',
            'add' => 0,
            'edit' => 0,
            'delete' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}

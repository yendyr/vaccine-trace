<?php

namespace Modules\Gate\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Menu;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $menu = Menu::create([
            'menu_link' => 'gate/user',
            'menu_text' => 'User',
            'parent' => 'Gate',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $menu = Menu::create([
            'menu_link' => 'gate/company',
            'menu_text' => 'Company',
            'parent' => 'Gate',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $menu = Menu::create([
            'menu_link' => 'gate/role',
            'menu_text' => 'Role',
            'parent' => 'Gate',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $menu = Menu::create([
            'menu_link' => 'gate/role-menu',
            'menu_text' => 'Role-menu',
            'parent' => 'Gate',
            'add' => 1,
            'update' => 0,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $menu = Menu::create([
            'menu_link' => 'examples/exaxmple',
            'menu_text' => 'Example',
            'parent' => 'Examples',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 7,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $menu = Menu::create([
            'menu_link' => 'hr/org-structure',
            'menu_text' => 'Organization Structure',
            'parent' => 'Human Resources',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $menu = Menu::create([
            'menu_link' => 'hr/org-structure-title',
            'menu_text' => 'Organization Structure Title',
            'parent' => 'Human Resources',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $menu = Menu::create([
            'menu_link' => 'hr/working-group',
            'menu_text' => 'Working Group',
            'parent' => 'Human Resources',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $menu = Menu::create([
            'menu_link' => 'hr/working-group-detail',
            'menu_text' => 'Working Group Detail',
            'parent' => 'Human Resources',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}

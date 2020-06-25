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
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $menu = Menu::create([
            'menu_link' => 'gate/company',
            'menu_text' => 'Company',
            'parent' => 'Gate',
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $menu = Menu::create([
            'menu_link' => 'gate/role',
            'menu_text' => 'Role',
            'parent' => 'Gate',
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $menu = Menu::create([
            'menu_link' => 'gate/role-menu',
            'menu_text' => 'Role-menu',
            'parent' => 'Gate',
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}

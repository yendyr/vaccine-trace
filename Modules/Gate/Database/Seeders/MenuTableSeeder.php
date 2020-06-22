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

        $menu1 = Menu::create([
            'menu_link' => 'gate/user',
            'parent' => 'Gate',
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $menu2 = Menu::create([
            'menu_link' => 'gate/company',
            'parent' => 'Gate',
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $menu3 = Menu::create([
            'menu_link' => 'gate/role',
            'parent' => 'Gate',
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $menu4 = Menu::create([
            'menu_link' => 'gate/menu',
            'parent' => 'Gate',
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}

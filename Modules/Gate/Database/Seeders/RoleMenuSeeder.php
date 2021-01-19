<?php

namespace Modules\Gate\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Gate\Entities\RoleMenu;

class RoleMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // --------- Role Menu Seeder for Default Role ID = 1 -------------- //
        $rolemenu = RoleMenu::create([
            'menu_id' => 2,
            'role_id' => 1,
            'menu_link' => 'gate/user',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => json_encode(0),
            'process' => json_encode(0),
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        
        $rolemenu = RoleMenu::create([
            'menu_id' => 4,
            'role_id' => 1,
            'menu_link' => 'gate/role',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => json_encode(0),
            'process' => json_encode(0),
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $rolemenu = RoleMenu::create([
            'menu_id' => 5,
            'role_id' => 1,
            'menu_link' => 'gate/menu',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => json_encode(0),
            'process' => json_encode(0),
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $rolemenu = RoleMenu::create([
            'menu_id' => 6,
            'role_id' => 1,
            'menu_link' => 'gate/role-menu',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => json_encode(0),
            'process' => json_encode(0),
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);        
        // --------- END Role Menu Seeder for Default Role ID = 1 -------------- //


        // --------- Role Menu Seeder for Default Role ID = 2 -------------- //
        $rolemenu = RoleMenu::create([
            'menu_id' => 2,
            'role_id' => 2,
            'menu_link' => 'gate/user',
            'add' => 0,
            'update' => 0,
            'delete' => 0,
            'print' => 0,
            'approval' => json_encode(0),
            'process' => json_encode(0),
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        
        $rolemenu = RoleMenu::create([
            'menu_id' => 4,
            'role_id' => 2,
            'menu_link' => 'gate/role',
            'add' => 0,
            'update' => 0,
            'delete' => 0,
            'print' => 0,
            'approval' => json_encode(0),
            'process' => json_encode(0),
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $rolemenu = RoleMenu::create([
            'menu_id' => 5,
            'role_id' => 2,
            'menu_link' => 'gate/menu',
            'add' => 0,
            'update' => 0,
            'delete' => 0,
            'print' => 0,
            'approval' => json_encode(0),
            'process' => json_encode(0),
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $rolemenu = RoleMenu::create([
            'menu_id' => 6,
            'role_id' => 2,
            'menu_link' => 'gate/role-menu',
            'add' => 0,
            'update' => 0,
            'delete' => 0,
            'print' => 0,
            'approval' => json_encode(0),
            'process' => json_encode(0),
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        // --------- END Role Menu Seeder for Default Role ID = 2 -------------- //
    }
}
<?php

namespace Modules\Gate\Database\Seeders\ModuleMenu;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Menu;

class VaksinasiMenuSeeder extends Seeder
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
            'menu_link' => 'vaksinasi/squad',
            'menu_text' => 'Master Satuan',
            'menu_route' => 'vaksinasi.squad.index',
            'menu_icon' => 'fa-bank',
            'menu_class' => 'Modules\Vaksinasi\Entities\Squad',
            'menu_id' => null,
            'menu_actives' => json_encode(['vaksinasi/squad', 'vaksinasi/squad/*']),
            'group' => 'Vaksinasi',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
    }
}
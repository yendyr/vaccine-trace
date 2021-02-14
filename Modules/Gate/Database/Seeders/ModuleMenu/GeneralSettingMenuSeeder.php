<?php

namespace Modules\Gate\Database\Seeders\ModuleMenu;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Menu;

class GeneralSettingMenuSeeder extends Seeder
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
            'menu_link' => 'generalsetting/country',
            'menu_text' => 'Master Country',
            'menu_route' => 'generalsetting.country.index',
            'menu_icon' => 'fa-globe',
            'menu_class' => 'Modules\GeneralSetting\Entities\Country',
            'menu_id' => null,
            'menu_actives' => json_encode(['generalsetting/country', 'generalsetting/country/*']),
            'group' => 'General Setting',
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

        Menu::create([
            'menu_link' => 'generalsetting/company',
            'menu_text' => 'Master Company',
            'menu_route' => 'generalsetting.company.index',
            'menu_icon' => 'fa-building',
            'menu_class' => 'Modules\GeneralSetting\Entities\Company',
            'menu_id' => null,
            'menu_actives' => json_encode(['generalsetting/company', 'generalsetting/company/*']),
            'group' => 'General Setting',
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

        Menu::create([
            'menu_link' => 'generalsetting/company-detail-contact',
            'menu_text' => '',
            'menu_route' => null,
            'menu_icon' => 'fa-building',
            'menu_class' => 'Modules\GeneralSetting\Entities\CompanyDetailContact',
            'menu_id' => null,
            'menu_actives' => json_encode(['generalsetting/company-detail-contact', 'generalsetting/company-detail-contact/*']),
            'group' => 'General Setting',
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

        Menu::create([
            'menu_link' => 'generalsetting/company-detail-address',
            'menu_text' => '',
            'menu_route' => null,
            'menu_icon' => 'fa-building',
            'menu_class' => 'Modules\GeneralSetting\Entities\CompanyDetailAddress',
            'menu_id' => null,
            'menu_actives' => json_encode(['generalsetting/company-detail-address', 'generalsetting/company-detail-address/*']),
            'group' => 'General Setting',
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

        Menu::create([
            'menu_link' => 'generalsetting/airport',
            'menu_text' => 'Master Airport',
            'menu_route' => 'generalsetting.airport.index',
            'menu_icon' => 'fa-university',
            'menu_class' => 'Modules\GeneralSetting\Entities\Airport',
            'menu_id' => null,
            'menu_actives' => json_encode(['generalsetting/airport', 'generalsetting/airport/*']),
            'group' => 'General Setting',
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
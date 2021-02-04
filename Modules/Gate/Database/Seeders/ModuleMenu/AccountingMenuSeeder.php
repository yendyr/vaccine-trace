<?php

namespace Modules\Gate\Database\Seeders\ModuleMenu;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Menu;

class AccountingMenuSeeder extends Seeder
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
            'menu_link' => 'accounting/chart-of-account',
            'menu_text' => 'Master COA',
            'menu_route' => 'accounting.chart-of-account.index',
            'menu_icon' => 'fa-folder',
            'menu_class' => 'Modules\Accounting\Entities\ChartOfAccount',
            'menu_id' => null,
            'menu_actives' => json_encode(['accounting/chart-of-account', 'accounting/chart-of-account/*']),
            'group' => 'Accounting',
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

        $menu = Menu::create([
            'menu_link' => 'accounting/item-category',
            'menu_text' => 'Item Category COA',
            'menu_route' => 'accounting.item-category.index_accounting',
            'menu_icon' => 'fa-share-alt',
            'menu_class' => 'Modules\SupplyChain\Entities\ItemCategory',
            'menu_id' => null,
            'menu_actives' => json_encode(['accounting/item-category', 'accounting/item-category/*']),
            'group' => 'Accounting',
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
        
        $menu = Menu::create([
            'menu_link' => 'accounting/item',
            'menu_text' => 'Item COA',
            'menu_route' => 'accounting.item.index_accounting',
            'menu_icon' => 'fa-cubes',
            'menu_class' => 'Modules\SupplyChain\Entities\Item',
            'menu_id' => null,
            'menu_actives' => json_encode(['accounting/item', 'accounting/item/*']),
            'group' => 'Accounting',
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
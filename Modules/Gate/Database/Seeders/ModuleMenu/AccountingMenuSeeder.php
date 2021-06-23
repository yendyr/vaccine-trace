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

        Menu::create([
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

        Menu::create([
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

        Menu::create([
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

        Menu::create([
            'menu_link' => 'accounting/journal',
            'menu_text' => 'Journal',
            'menu_route' => 'accounting.journal.index',
            'menu_icon' => 'fa-tasks',
            'menu_class' => 'Modules\Accounting\Entities\Journal',
            'menu_id' => null,
            'menu_actives' => json_encode(['accounting/journal', 'accounting/journal/*']),
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

        $menuReport = Menu::create([
            'menu_link' => '#',
            'menu_text' => 'Report',
            'menu_route' => null,
            'menu_icon' => 'fa-line-chart',
            'menu_class' => null,
            'menu_id' => null,
            'group' => 'Accounting',
            'add' => 0,
            'update' => 0,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);

        Menu::create([
            'menu_link' => 'accounting/general-ledger',
            'menu_text' => 'General Ledger',
            'menu_route' => 'accounting.general-ledger.index',
            'menu_icon' => 'fa-window-restore',
            'menu_class' => 'Modules\Accounting\Entities\GeneralLedger',
            'menu_id' => null,
            'menu_actives' => json_encode(['accounting/general-ledger', 'accounting/general-ledger/*']),
            'group' => 'Accounting',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuReport->id
        ]);

        Menu::create([
            'menu_link' => 'accounting/trial-balance',
            'menu_text' => 'Trial Balance',
            'menu_route' => 'accounting.trial-balance.index',
            'menu_icon' => 'fa-indent',
            'menu_class' => 'Modules\Accounting\Entities\Journal',
            'menu_id' => null,
            'menu_actives' => json_encode(['accounting/trial-balance', 'accounting/trial-balance/*']),
            'group' => 'Accounting',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuReport->id
        ]);
    }
}

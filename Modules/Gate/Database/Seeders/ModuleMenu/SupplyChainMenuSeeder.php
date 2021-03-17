<?php

namespace Modules\Gate\Database\Seeders\ModuleMenu;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Menu;

class SupplyChainMenuSeeder extends Seeder
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
            'menu_link' => 'supplychain/warehouse',
            'menu_text' => 'Master Warehouse',
            'menu_route' => 'supplychain.warehouse.index',
            'menu_icon' => 'fa-database',
            'menu_class' => 'Modules\SupplyChain\Entities\Warehouse',
            'menu_id' => null,
            'menu_actives' => json_encode(['supplychain/warehouse', 'supplychain/warehouse/*']),
            'group' => 'Supply Chain',
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
            'menu_link' => 'supplychain/unit',
            'menu_text' => 'Master Unit',
            'menu_route' => 'supplychain.unit.index',
            'menu_icon' => 'fa-underline',
            'menu_class' => 'Modules\SupplyChain\Entities\Unit',
            'menu_id' => null,
            'menu_actives' => json_encode(['supplychain/unit', 'supplychain/unit/*']),
            'group' => 'Supply Chain',
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
            'menu_link' => 'supplychain/item-category',
            'menu_text' => 'Master Item Category',
            'menu_route' => 'supplychain.item-category.index',
            'menu_icon' => 'fa-share-alt',
            'menu_class' => 'Modules\SupplyChain\Entities\ItemCategory',
            'menu_id' => null,
            'menu_actives' => json_encode(['supplychain/item-category', 'supplychain/item-category/*']),
            'group' => 'Supply Chain',
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
            'menu_link' => 'supplychain/item',
            'menu_text' => 'Master Item',
            'menu_route' => 'supplychain.item.index',
            'menu_icon' => 'fa-cubes',
            'menu_class' => 'Modules\SupplyChain\Entities\Item',
            'menu_id' => null,
            'menu_actives' => json_encode(['supplychain/item', 'supplychain/item/*']),
            'group' => 'Supply Chain',
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

        $menuMutation = Menu::create([
            'menu_link' => '#',
            'menu_text' => 'Inventory/Stock Mutation',
            'menu_route' => null,
            'menu_icon' => 'fa-exchange',
            'menu_class' => null,
            'menu_id' => null,
            'group' => 'Supply Chain',
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
            'menu_link' => 'supplychain/mutation-inbound',
            'menu_text' => 'Inbound',
            'menu_route' => 'supplychain.mutation-inbound.index',
            'menu_icon' => 'fa-cloud-download',
            'menu_class' => 'Modules\SupplyChain\Entities\StockMutation',
            'menu_id' => null,
            'menu_actives' => json_encode(['supplychain/mutation-inbound', 'supplychain/mutation-inbound/*']),
            'group' => 'Supply Chain',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuMutation->id
        ]);

        Menu::create([
            'menu_link' => 'supplychain/mutation-outbound',
            'menu_text' => 'Outbound',
            'menu_route' => 'supplychain.mutation-outbound.index',
            'menu_icon' => 'fa-cloud-upload',
            'menu_class' => 'Modules\SupplyChain\Entities\StockMutation',
            'menu_id' => null,
            'menu_actives' => json_encode(['supplychain/mutation-outbound', 'supplychain/mutation-outbound/*']),
            'group' => 'Supply Chain',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuMutation->id
        ]);

        Menu::create([
            'menu_link' => 'supplychain/mutation-transfer',
            'menu_text' => 'Transfer/Internal Movement',
            'menu_route' => 'supplychain.mutation-transfer.index',
            'menu_icon' => 'fa-random',
            'menu_class' => 'Modules\SupplyChain\Entities\StockMutation',
            'menu_id' => null,
            'menu_actives' => json_encode(['supplychain/mutation-transfer', 'supplychain/mutation-transfer/*']),
            'group' => 'Supply Chain',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuMutation->id
        ]);

        Menu::create([
            'menu_link' => 'supplychain/stock-monitoring',
            'menu_text' => 'Stock Monitoring',
            'menu_route' => 'supplychain.stock-monitoring.index',
            'menu_icon' => 'fa-hdd-o',
            'menu_class' => 'Modules\SupplyChain\Entities\ItemStock',
            'menu_id' => null,
            'menu_actives' => json_encode(['supplychain/stock-monitoring', 'supplychain/stock-monitoring/*']),
            'group' => 'Supply Chain',
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
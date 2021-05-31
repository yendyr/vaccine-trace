<?php

namespace Modules\Gate\Database\Seeders\ModuleMenu;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Menu;

class ProcurementSeeder extends Seeder
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
            'menu_link' => 'procurement/purchase-requisition',
            'menu_text' => 'Purchase Requisition',
            'menu_route' => 'procurement.purchase-requisition.index',
            'menu_icon' => 'fa-shopping-bag',
            'menu_class' => 'Modules\Procurement\Entities\PurchaseRequisition',
            'menu_id' => null,
            'menu_actives' => json_encode(['procurement/purchase-requisition', 'procurement/purchase-requisition/*']),
            'group' => 'Procurement',
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
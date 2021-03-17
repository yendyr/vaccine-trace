<?php

namespace app\Helpers\SupplyChain;

use Modules\SupplyChain\Entities\ItemStock;

class ItemStockChecker
{
    public static function all_status()
    {
        $data = ItemStock::with(['item.unit',
                                'item_group:id,item_id,alias_name,coding,parent_coding',
                                'warehouse'])
                                ->whereHas('warehouse', function ($warehouse) {
                                    $warehouse->whereHas('aircraft_configuration', function ($aircraft_configuration) {
                                        $aircraft_configuration->has('approvals');
                                    })
                                    ->orWhere('aircraft_configuration_id', null);
                                });
        return $data;
    }
}
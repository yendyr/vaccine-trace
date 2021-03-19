<?php

namespace app\Helpers\SupplyChain;

use Modules\SupplyChain\Entities\ItemStock;
use Yajra\DataTables\Facades\DataTables;

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
                                
        return Datatables::of($data)
                ->addColumn('warehouse', function($row){
                    if ($row->warehouse->is_aircraft == 1) {
                        return '<strong>Aircraft:</strong><br>' . $row->warehouse->aircraft_configuration->registration_number . '<br>' . $row->warehouse->aircraft_configuration->serial_number;
                    } 
                    else {
                        return $row->warehouse->name;
                    }
                })
                ->addColumn('parent', function($row){
                    if ($row->item_group) {
                        return 'P/N: ' . $row->item_group->item->code . '<br>' . 
                        'S/N: ' . $row->item_group->serial_number . '<br>' .
                        'Name: ' . $row->item_group->item->name . '<br>' .
                        'Alias: ' . $row->item_group->alias_name . '<br>';
                    } 
                    else {
                        return "<span class='text-muted font-italic'>Not Set</span>";
                    }
                })
                ->escapeColumns([])
                ->make(true);
    }
}
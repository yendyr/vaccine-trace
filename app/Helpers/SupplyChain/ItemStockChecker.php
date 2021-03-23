<?php

namespace app\Helpers\SupplyChain;

use Modules\SupplyChain\Entities\ItemStock;
use Yajra\DataTables\Facades\DataTables;

class ItemStockChecker
{
    public static function usable_items($warehouse_id, $with_use_button)
    {
        $result = ItemStock::with(['item.unit',
                                'item_group:id,item_id,serial_number,alias_name,coding,parent_coding',
                                'warehouse'])
                                ->whereHas('warehouse', function ($warehouse) {
                                    $warehouse->whereHas('aircraft_configuration', function ($aircraft_configuration) {
                                        $aircraft_configuration->has('approvals');
                                    })
                                    ->orWhere('aircraft_configuration_id', null);
                                })
                                ->whereRaw('item_stocks.quantity > item_stocks.used_quantity');
        if ($warehouse_id) {
            $result = $result->where('warehouse_id', $warehouse_id);
        }
                    
        if (!$with_use_button) {
            return Self::with_general_custom_column($result);
        }
        else {
            return Self::with_use_button_custom_column($result);
        }
    }

    public static function with_general_custom_column($table) {
        return Datatables::of($table)
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
                        return 'P/N: <strong>' . $row->item_group->item->code . '</strong><br>' . 
                        'S/N: <strong>' . $row->item_group->serial_number . '</strong><br>' .
                        'Name: <strong>' . $row->item_group->item->name . '</strong><br>' .
                        'Alias: <strong>' . $row->item_group->alias_name . '</strong><br>';
                    } 
                    else {
                        return "<span class='text-muted font-italic'>Not Set</span>";
                    }
                })
                ->escapeColumns([])
                ->make(true);
    }

    public static function with_use_button_custom_column($table) {
        return Datatables::of($table)
                // ->addColumn('warehouse', function($row){
                //     if ($row->warehouse->is_aircraft == 1) {
                //         return '<strong>Aircraft:</strong><br>' . $row->warehouse->aircraft_configuration->registration_number . '<br>' . $row->warehouse->aircraft_configuration->serial_number;
                //     } 
                //     else {
                //         return $row->warehouse->name;
                //     }
                // })
                ->addColumn('parent', function($row){
                    if ($row->item_group) {
                        return 'P/N: <strong>' . $row->item_group->item->code . '</strong><br>' . 
                        'S/N: <strong>' . $row->item_group->serial_number . '</strong><br>' .
                        'Name: <strong>' . $row->item_group->item->name . '</strong><br>' .
                        'Alias: <strong>' . $row->item_group->alias_name . '</strong><br>';
                    } 
                    else {
                        return "<span class='text-muted font-italic'>Not Set</span>";
                    }
                })
                ->addColumn('action', function($row){
                    if ($row->parent_coding) {
                        return "<span class='text-muted font-italic'>this Item has Parent</span>";
                    }
                    else {
                        $usable = true;
                        $idToUse = $row->id;
                        return view('components.action-button', compact(['usable', 'idToUse']));
                    }
                })
                ->escapeColumns([])
                ->make(true);
    }
}
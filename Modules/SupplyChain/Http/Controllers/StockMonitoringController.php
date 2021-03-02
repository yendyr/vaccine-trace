<?php

namespace Modules\SupplyChain\Http\Controllers;

use Modules\SupplyChain\Entities\ItemStock;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;

class StockMonitoringController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(ItemStock::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ItemStock::with(['item:id,code,name',
                                    'item_group:id,item_id,alias_name,coding,parent_coding',
                                    'warehouse'])
                                ->get();

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
                        return $row->item_group->item->code . ' | ' . 
                        $row->item_group->item->name . ' | ' .
                        $row->item_group->alias_name . ' | ';
                    } 
                    else {
                        return "<span class='text-muted font-italic'>Not Set</span>";
                    }
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('supplychain::pages.stock-monitoring.index');
    }
}
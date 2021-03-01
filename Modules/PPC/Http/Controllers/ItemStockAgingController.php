<?php

namespace Modules\PPC\Http\Controllers;

use Modules\SupplyChain\Entities\ItemStock;
use Modules\PPC\Entities\ItemStockAging;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;

class ItemStockAgingController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(ItemStockAging::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ItemStock::with(['item:id,code,name',
                                    'warehouse',
                                    'item_stock_initial_aging',
                                    'item_stock_agings'])
                                    ->get();

            return Datatables::of($data)
                ->addColumn('current_position', function($row){
                    if ($row->warehouse->is_aircraft == 1) {
                        return '<strong>Aircraft:</strong><br>' . $row->warehouse->aircraft_configuration->registration_number . '<br>' . $row->warehouse->aircraft_configuration->serial_number;
                    } 
                    else {
                        return $row->warehouse->name;
                    }
                })
                ->addColumn('initial_status', function($row) {
                    return $row->item_stock_initial_aging->initial_flight_hour . ' FH<br>' . $row->item_stock_initial_aging->initial_block_hour . ' BH<br>' . $row->item_stock_initial_aging->initial_flight_cycle . ' FC<br>' . $row->item_stock_initial_aging->initial_flight_event . ' Evt(s)';
                })
                ->addColumn('in_period_aging', function($row) {
                    return number_format($row->item_stock_agings->sum('flight_hour'), 2, '.', '') . ' FH<br>' . 
                    number_format($row->item_stock_agings->sum('block_hour'), 2, '.', '') . ' BH<br>' . 
                    $row->item_stock_agings->sum('flight_cycle') . ' FC<br>' . 
                    $row->item_stock_agings->sum('flight_event') . ' Evt(s)';
                })
                ->addColumn('current_status', function($row) {
                    return '<strong>' . number_format(($row->item_stock_initial_aging->initial_flight_hour + $row->item_stock_agings->sum('flight_hour')), 2, '.', '') . '</strong> FH<br>' . 
                    '<strong>' . number_format(($row->item_stock_initial_aging->initial_block_hour + $row->item_stock_agings->sum('block_hour')), 2, '.', '') . '</strong> BH<br>' . 
                    '<strong>' . ($row->item_stock_initial_aging->initial_flight_cycle + $row->item_stock_agings->sum('flight_cycle')) . '</strong> FC<br>' . 
                    '<strong>' . ($row->item_stock_initial_aging->initial_flight_event + $row->item_stock_agings->sum('flight_event')) . '</strong> Evt(s)';
                })
                ->addColumn('month_since_start', function($row) {
                    $now = Carbon::now();
                    if($row->item_stock_initial_aging->initial_start_date) {
                        $start = Carbon::parse($row->item_stock_initial_aging->initial_start_date);

                        $diff = $now->diffInMonths($start);
                        return '<strong>' . $diff . '</strong> Month(s)';
                    }
                    else if($row->warehouse->aircraft_configuration) {
                        if($row->warehouse->aircraft_configuration->initial_start_date) {
                            $start = Carbon::parse($row->warehouse->aircraft_configuration->initial_start_date);

                            $diff = $now->diffInMonths($start);
                            return '<strong>' . $diff . '</strong> Month(s)';
                        }
                    }
                    else {
                        return null;
                    }
                })
                ->addColumn('expired_date', function($row) {
                    return $row->item_stock_initial_aging->expired_date;
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('ppc::pages.item-aging-report.index');
    }

    // public function show(ItemStockAging $ItemStockAging)
    // {
    //     return view('ppc::pages.item-aging-report.show');
    // }
}
<?php

namespace Modules\PPC\Http\Controllers;

use Modules\PPC\Entities\ItemStockAging;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

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
            $data = ItemStockAging::with(['item_stock.item',
                                        'item_stock.warehouse'])
                                    ->select('item_stock_id', DB::raw('sum(flight_hour) as fh'), DB::raw('sum(block_hour) as bh'), DB::raw('sum(flight_cycle) as fc'), DB::raw('sum(flight_event) as fe'))
                                    ->groupBy('item_stock_id')
                                    ->get();

            return Datatables::of($data)
                ->addColumn('current_position', function($row){
                    if ($row->item_stock->warehouse->is_aircraft == 1) {
                        return $row->item_stock->warehouse->aircraft_configuration->registration_number . ' | ' . $row->item_stock->warehouse->aircraft_configuration->serial_number;
                    } 
                    else {
                        return $row->item_stock->warehouse->name;
                    }
                })
                ->addColumn('initial_status', function($row) {
                    return $row->item_stock->initial_flight_hour . ' FH / ' . $row->item_stock->initial_block_hour . ' BH / ' . $row->item_stock->initial_flight_cycle . ' FC / ' . $row->item_stock->initial_flight_event . ' Evt(s)';
                })
                ->addColumn('in_period_aging', function($row) {
                    return number_format($row->fh, 2, '.', '') . ' FH / ' . 
                    number_format($row->bh, 2, '.', '') . ' BH / ' . 
                    $row->fc . ' FC / ' . 
                    $row->fe . ' Evt(s)';
                })
                ->addColumn('current_status', function($row) {
                    return '<strong>' . number_format(($row->item_stock->initial_flight_hour + $row->fh), 2, '.', '') . '</strong> FH / ' . 
                    '<strong>' . number_format(($row->item_stock->initial_block_hour + $row->bh), 2, '.', '') . '</strong> BH / ' . 
                    '<strong>' . ($row->item_stock->initial_flight_cycle + $row->fc) . '</strong> FC / ' . 
                    '<strong>' . ($row->item_stock->initial_flight_event + $row->fe) . '</strong> Evt(s)';
                })
                ->addColumn('expired_date', function($row) {
                    return $row->item_stock->expired_date;
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
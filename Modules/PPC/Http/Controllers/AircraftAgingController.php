<?php

namespace Modules\PPC\Http\Controllers;

use Modules\FlightOperations\Entities\AfmLog;
use Modules\PPC\Entities\ItemStockAging;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;

class AircraftAgingController extends Controller
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
            $data = AfmLog::with(['aircraft_configuration.aircraft_type.manufacturer',
                                ])
                                ->select('aircraft_configuration_id', DB::raw('sum(total_flight_hour) as fh'), DB::raw('sum(total_block_hour) as bh'), DB::raw('sum(total_flight_cycle) as fc'), DB::raw('sum(total_flight_event) as fe'))
                                ->groupBy('aircraft_configuration_id')
                                ->get();

            return Datatables::of($data)
                ->addColumn('initial_start_date', function($row){
                    if ($row->aircraft_configuration->initial_start_date) {
                        $date = Carbon::parse($row->aircraft_configuration->initial_start_date)->format('Y-M-d');

                        return $date;
                    } 
                })
                ->addColumn('initial_status', function($row) {
                    return $row->aircraft_configuration->initial_flight_hour . ' FH<br>' . $row->aircraft_configuration->initial_block_hour . ' BH<br>' . $row->aircraft_configuration->initial_flight_cycle . ' FC<br>' . $row->aircraft_configuration->initial_flight_event . ' Evt(s)';
                })
                ->addColumn('in_period_aging', function($row) {
                    return number_format($row->fh, 2, '.', '') . ' FH<br>' . 
                    number_format($row->bh, 2, '.', '') . ' BH<br>' . 
                    $row->fc . ' FC<br>' . 
                    $row->fe . ' Evt(s)';
                })
                ->addColumn('current_status', function($row) {
                    return '<strong>' . number_format(($row->aircraft_configuration->initial_flight_hour + $row->fh), 2, '.', '') . '</strong> FH<br>' . 
                    '<strong>' . number_format(($row->aircraft_configuration->initial_block_hour + $row->bh), 2, '.', '') . '</strong> BH<br>' . 
                    '<strong>' . ($row->aircraft_configuration->initial_flight_cycle + $row->fc) . '</strong> FC<br>' . 
                    '<strong>' . ($row->aircraft_configuration->initial_flight_event + $row->fe) . '</strong> Evt(s)';
                })
                ->addColumn('month_since_start', function($row) {
                    $now = Carbon::now();
                    if($row->aircraft_configuration->initial_start_date) {
                        $start = Carbon::parse($row->aircraft_configuration->initial_start_date);
                    }
                    else {
                        $start = Carbon::now();
                    }
                    $diff = $now->diffInMonths($start);
                    return '<strong>' . $diff . '</strong> Month(s)';
                })
                // ->addColumn('expired_date', function($row) {
                //     return $row->item_stock->expired_date;
                // })
                ->escapeColumns([])
                ->make(true);
        }
        return view('ppc::pages.aircraft-aging-report.index');
    }
}
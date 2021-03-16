<?php

namespace Modules\PPC\Http\Controllers;

use Modules\PPC\Entities\AircraftConfiguration;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;

class AircraftAgingController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(AircraftConfiguration::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AircraftConfiguration::with(['aircraft_type.manufacturer',
                                                'afm_logs'])
                                        ->has('approvals');

            return Datatables::of($data)
                ->addColumn('initial_start_date', function($row){
                    if ($row->initial_start_date) {
                        $date = Carbon::parse($row->initial_start_date)->format('Y-M-d');

                        return $date;
                    } 
                })
                ->addColumn('initial_status', function($row) {
                    return $row->initial_flight_hour . ' FH<br>' . 
                    $row->initial_block_hour . ' BH<br>' . 
                    $row->initial_flight_cycle . ' FC<br>' . 
                    $row->initial_flight_event . ' Evt(s)';
                })
                ->addColumn('in_period_aging', function($row) {
                    return number_format($row->afm_logs->sum('total_flight_hour'), 2, '.', '') . ' FH<br>' . 
                    number_format($row->afm_logs->sum('total_block_hour'), 2, '.', '') . ' BH<br>' . 
                    $row->afm_logs->sum('total_flight_cycle') . ' FC<br>' . 
                    $row->afm_logs->sum('total_flight_event') . ' Evt(s)';
                })
                ->addColumn('current_status', function($row) {
                    return '<strong>' . number_format(($row->initial_flight_hour + $row->afm_logs->sum('total_flight_hour')), 2, '.', '') . '</strong> FH<br>' . 
                    '<strong>' . number_format(($row->initial_block_hour + $row->afm_logs->sum('total_block_hour')), 2, '.', '') . '</strong> BH<br>' . 
                    '<strong>' . ($row->initial_flight_cycle + $row->afm_logs->sum('total_flight_cycle')) . '</strong> FC<br>' . 
                    '<strong>' . ($row->initial_flight_event + $row->afm_logs->sum('total_flight_event')) . '</strong> Evt(s)';
                })
                ->addColumn('month_since_start', function($row) {
                    $now = Carbon::now();
                    if($row->initial_start_date) {
                        $start = Carbon::parse($row->initial_start_date);
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
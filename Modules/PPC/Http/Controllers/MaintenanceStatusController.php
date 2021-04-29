<?php

namespace Modules\PPC\Http\Controllers;

use Modules\PPC\Entities\AircraftConfiguration;
use Modules\PPC\Entities\MaintenanceProgram;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;

class MaintenanceStatusController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        // $this->authorizeResource(AircraftConfiguration::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('ppc::pages.maintenance-status-report.index');
    }

    public function show(AircraftConfiguration $AircraftConfiguration)
    {
        return view('ppc::pages.maintenance-status-report.show', compact('AircraftConfiguration'));
    }
}
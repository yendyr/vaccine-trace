<?php

namespace Modules\PPC\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\PPC\Entities\AircraftConfiguration;
use Modules\PPC\Entities\WorkOrder;
use Yajra\DataTables\Facades\DataTables;

class WorkOrderController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(WorkOrder::class);
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $work_orders = WorkOrder::latest();

            return Datatables::of($work_orders)->make();
        }

        return view('ppc::pages.work-order.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('ppc::pages.work-order.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        $flag = true;

        if($flag) {
            DB::commit();

            return response()->json(true);
        }else{
            DB::rollBack();

            return response()->json(false);
        }

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('ppc::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('ppc::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        $flag = true;

        if($flag) {
            DB::commit();

            return response()->json(true);
        }else{
            DB::rollBack();

            return response()->json(false);
        }

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        $flag = true;

        if($flag) {
            DB::commit();

            return response()->json(true);
        }else{
            DB::rollBack();

            return response()->json(false);
        }

    }

    public function select2Aircraft(Request $request)
    {
        $search = $request->term;

        $AircraftConfigurations = AircraftConfiguration::has('approvals')->get();

        if($search != '') {
            $AircraftConfigurations = AircraftConfiguration::has('approvals')
                                        ->where('registration_number', 'like', '%' .$search. '%')
                                        ->orWhere('serial_number', 'like', '%' .$search. '%')
                                        ->with(['aircraft_type' => function($q) use ($search) {
                                            $q->where('code', 'like', '%' .$search. '%')
                                            ->orWhere('name', 'like', '%' .$search. '%');
                                        }])
                                        ->get();
        }

        $response = [];

        foreach($AircraftConfigurations as $AircraftConfigurationRow){
            $response['results'][] = [
                "id" => $AircraftConfigurationRow->id,
                "text" => '['.$AircraftConfigurationRow->aircraft_type->code.'] '.$AircraftConfigurationRow->aircraft_type->name . ' | ' . $AircraftConfigurationRow->serial_number . ' | ' .$AircraftConfigurationRow->registration_number
            ];
        }

        return response()->json($response);
    }
}

<?php

namespace Modules\PPC\Http\Controllers;

use Carbon\Carbon;
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
            $work_orders = WorkOrder::with('aircraft:id,registration_number,serial_number,aircraft_type_id', 'aircraft.aircraft_type:id,code,name')->latest();

            return Datatables::of($work_orders)
                ->addColumn('number', function ($row) use ($request) {
                    if (!$request->aircraft_type_id) {
                        $noAuthorize = true;
                        if (Auth::user()->can('view', WorkOrder::class)) {
                            $showText = $row->code;
                            $showValue = $row->id;
                            $noAuthorize = false;
                        }

                        if ($noAuthorize == false) {
                            return  '<a href="'. route('ppc.work-order.show', ['work_order' => $showValue]) .'">'. $showText .'</a>';
                        } else {
                            return '<p class="text-muted font-italic">Not Authorized</p>';
                        }
                    } 
                })
                ->addColumn('action', function ($row) use ($request) {
                    if (!$request->aircraft_type_id) {
                        $noAuthorize = true;
                        if (Auth::user()->can('update', WorkOrder::class)) {
                            $updateable = 'button';
                            $updateValue = $row->id;
                            $noAuthorize = false;
                        }
                        if (Auth::user()->can('delete', WorkOrder::class)) {
                            $deleteable = true;
                            $deleteId = $row->id;
                            $noAuthorize = false;
                        }

                        if ($noAuthorize == false) {
                            return view('components.action-button', compact(['updateable', 'updateValue', 'deleteable', 'deleteId']));
                        } else {
                            return '<p class="text-muted font-italic">Not Authorized</p>';
                        }
                    } else if ($request->create_maintenance_program) {
                        $usable = true;
                        $idToUse = $row->id;
                        return view('components.action-button', compact(['usable', 'idToUse']));
                    }
                })
                ->escapeColumns([])
                ->make();
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
        $request->validate([
            'code' => ['required', 'max:30'],
            'name' => ['required', 'max:30'],
            'aircraft_registration_number' => ['required', 'max:30'],
            'aircraft_serial_number' => ['required', 'max:30'],
            'aircraft_id' => ['required', 'exists:aircraft_configurations,id'],
        ]);

        DB::beginTransaction();

        $request->merge([
            'uuid' =>  Str::uuid(),
            'owned_by' => $request->user()->company_id,
            'status' => 1,
            'created_by' => $request->user()->id,
        ]);

        $flag = true;
        $transaction_date = Carbon::now();
        $work_order = WorkOrder::create($request->all());

        if (!$work_order->id) {
            $flag = false;
        } else {
            $code = 'WKORD-' .  $transaction_date->year . '-' . str_pad($work_order->id, 5, '0', STR_PAD_LEFT);

            $update_res = $work_order->update([
                'code' => $code
            ]);

            if (!$update_res) {
                $flag = false;
            }
        }

        if ($flag) {
            DB::commit();

            return response()->json(['success' => 'Work Order has been created']);
        } else {
            DB::rollBack();

            return response()->json(['error' => "Work Order failed to create"]);
        }
    }

    /**
     * Show the specified resource.
     * @param WorkOrder $work_order
     * @return Renderable
     */
    public function show(WorkOrder $work_order)
    {
        return view('ppc::pages.work-order.show', [
            'work_order' => $work_order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param WorkOrder $work_order
     * @return Renderable
     */
    public function edit(WorkOrder $work_order)
    {
        return view('ppc::pages.work-order.edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param WorkOrder $work_order
     * @return Renderable
     */
    public function update(Request $request, WorkOrder $work_order)
    {
        $request->validate([
            'code' => ['required', 'max:30'],
            'name' => ['required', 'max:30'],
            'aircraft_registration_number' => ['required', 'max:30'],
            'aircraft_serial_number' => ['required', 'max:30'],
            'aircraft_id' => ['required', 'exists:aircraft_configurations,id'],
        ]);

        DB::beginTransaction();
        $flag = true;
        $result = $work_order->update($request->all());

        if( !$result ) {
            $flag = false;
        }

        if ($flag) {
            DB::commit();

            return response()->json(['success' => 'Work Order has been updated']);
        } else {
            DB::rollBack();

            return response()->json(['error' => "Work Order failed to update"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param WorkOrder $work_order
     * @return Renderable
     */
    public function destroy(WorkOrder $work_order)
    {
        DB::beginTransaction();

        $flag = true;

        $result = $work_order->delete();

        if( !$result ) {
            $flag = false;
        }
        
        if ($flag) {
            DB::commit();

            return response()->json(['success' => 'Work Order has been deleted']);
        } else {
            DB::rollBack();

            return response()->json(['error' => "Work Order failed to delete"]);
        }
    }

    // Fuction File Upload
    public function fileUpload(Request $request, WorkOrder $work_order)
    {
        if($request->ajax()) {
            $data = $request->file('file');
            $extension = $data->getClientOriginalExtension();
            $filename = 'work_order_attachment_' . $work_order->id . '.' . $extension;
            $path = public_path('uploads/company/' . $work_order->owned_by . '/work_order/');
            
            $workOrderFile = public_path('uploads/company/' . $work_order->owned_by . '/work_order/' . $filename);

            if (File::exists($workOrderFile)) {
                unlink($workOrderFile);
            }

            $successText = 'Work Order Attachment has been Updated';

            WorkOrder::where('id', $work_order->id)
                ->first()->update([
                    'file_attachment' => $filename,
                    'updated_by' => $request->user()->id
                ]);

            $data->move($path, $filename);

            return response()->json(['success' => $successText]);
        }
    }

    public function select2Aircraft(Request $request)
    {
        $search = $request->term;

        $AircraftConfigurations = AircraftConfiguration::has('approvals')->get();

        if ($search != '') {
            $AircraftConfigurations = AircraftConfiguration::has('approvals')
                ->where('registration_number', 'like', '%' . $search . '%')
                ->orWhere('serial_number', 'like', '%' . $search . '%')
                ->with(['aircraft_type' => function ($q) use ($search) {
                    $q->where('code', 'like', '%' . $search . '%')
                        ->orWhere('name', 'like', '%' . $search . '%');
                }])
                ->get();
        }

        $response = [];

        foreach ($AircraftConfigurations as $AircraftConfigurationRow) {
            $response['results'][] = [
                "id" => $AircraftConfigurationRow->id,
                "text" => '[' . $AircraftConfigurationRow->aircraft_type->code . '] ' . $AircraftConfigurationRow->aircraft_type->name . ' | ' . $AircraftConfigurationRow->serial_number . ' | ' . $AircraftConfigurationRow->registration_number
            ];
        }

        return response()->json($response);
    }
}

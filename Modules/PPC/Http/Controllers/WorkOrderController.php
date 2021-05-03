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
use Modules\PPC\Entities\WorkOrderApproval;
use Modules\PPC\Entities\WOWPTaskcardItem;
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
                        if ( $request->user()->can('view', WorkOrder::class)) {
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

                        if ( $request->user()->can('update', $row) ) {
                            $updateable = 'button';
                            $updateValue = $row->id;
                            $noAuthorize = false;
                        }else{
                            $updateable = null;
                            $updateValue = null;
                        }

                        if ( $request->user()->can('delete', $row) ) {
                            $deleteable = true;
                            $deleteId = $row->id;
                            $noAuthorize = false;
                        }else{
                            $deleteable = null;
                            $deleteId = null;
                        }

                        if ( $request->user()->can('approval', $row) ) {
                            $approvable = true;
                            $approveId = $row->id;
                            $noAuthorize = false;
                        }else{
                            $approvable = null;
                            $approveId = null;
                        }

                        if ($noAuthorize == false) {
                            return view('components.action-button', compact(['updateable', 'updateValue', 'deleteable', 'deleteId', 'approvable', 'approveId']));
                        } else {
                            return '<p class="text-muted font-italic">Not Authorized</p>';
                        }
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
        $skills = $taskcard_counts = [];

        if( $work_order->taskcards()->count() > 0 ) {
            foreach ($work_order->taskcards as $taskcardRow) {
                
                $taskcard_group = json_decode($taskcardRow->taskcard_group_json);

                if( !empty($taskcard_group) ) {
                    if( empty($taskcard_counts[$taskcard_group->code]) ){
                        $taskcard_counts[$taskcard_group->code]['name'] = $taskcard_group->name;
                        $taskcard_counts[$taskcard_group->code]['count'] = 1;
                    }else{
                        $taskcard_counts[$taskcard_group->code]['count']++;
                    }
                }

                $instruction_details = json_decode($taskcardRow->instruction_details_json);

    
                if( !empty($instruction_details) ) {

                    foreach( $instruction_details as $instruction_detail_row ) {

                        if( sizeof($instruction_detail_row->skills) > 0 ) {

                            foreach ($instruction_detail_row->skills as $skillRow) {

                                if( isset($skills[$skillRow->name]) ) {
                                    $skills[$skillRow->name]++;
                                }else{
                                    $skills[$skillRow->name] = 1;
                                }

                            }
                            
                        }

                    }

                } 
                
            }
        }

        return view('ppc::pages.work-order.show', [
            'skills' => $skills,
            'work_order' => $work_order,
            'taskcard_counts' => $taskcard_counts
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param WorkOrder $work_order
     * @return Renderable
     */
    public function edit(WorkOrder $work_order)
    {
        $skills = $taskcard_counts = [];

        if( $work_order->taskcards()->count() > 0 ) {
            foreach ($work_order->taskcards as $taskcardRow) {
                dd($taskcardRow);
                $taskcard_group = json_decode($taskcardRow->taskcard_group_json);

                if( !empty($taskcard_group) ) {
                    if( empty($taskcard_counts[$taskcard_group->code]) ){
                        $taskcard_counts[$taskcard_group->code]['name'] = $taskcard_group->name;
                        $taskcard_counts[$taskcard_group->code]['count'] = 1;
                    }else{
                        $taskcard_counts[$taskcard_group->code]['count']++;
                    }
                }

                $instruction_details = json_decode($taskcardRow->instruction_details_json);

    
                if( !empty($instruction_details) ) {

                    foreach( $instruction_details as $instruction_detail_row ) {

                        if( sizeof($instruction_detail_row->skills) > 0 ) {

                            foreach ($instruction_detail_row->skills as $skillRow) {

                                if( isset($skills[$skillRow->name]) ) {
                                    $skills[$skillRow->name]++;
                                }else{
                                    $skills[$skillRow->name] = 1;
                                }

                            }
                            
                        }

                    }

                } 
                
            }
        }

        return view('ppc::pages.work-order.edit', [
            'skills' => $skills,
            'work_order' => $work_order,
            'taskcard_counts' => $taskcard_counts
        ]);
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
        $result = $work_order->update($request->except(['code']));

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

    public function approve(Request $request, WorkOrder $work_order)
    {
        $is_authorized = $this->authorize('approval', $work_order->id);

        $request->validate([
            'approval_notes' => ['required', 'max:30'],
        ]);

        DB::beginTransaction();
        $flag = true;

        $approval = WorkOrderApproval::create([
            'uuid' =>  Str::uuid(),

            'work_order_id' =>  $work_order->id,
            'approval_notes' =>  $request->approval_notes,
    
            'owned_by' => $request->user()->company_id,
            'status' => 1,
            'created_by' => Auth::user()->id,
        ]);
        
        if( !get_class($approval) ) {
            $flag = false;
        }

        if( $flag ) {
            DB::commit();
    
            return response()->json(['success' => 'Work Order Data has been Approved']);
        }else{
            DB::rollBack();

            return response()->json(['error' => 'Failed to Approve Work Order Data']);
        }

    }

    // Fuction File Upload
    public function fileUpload(Request $request, WorkOrder $work_order)
    {
        if($request->ajax()) {
            DB::beginTransaction();
            $flag = true;
            $data = $request->file('file');
            $extension = $data->getClientOriginalExtension();
            $filename = 'work_order_attachment_' . $work_order->id . '.' . $extension;
            $path = public_path('uploads/company/' . $work_order->owned_by . '/work_order/');
            
            $workOrderFile = public_path('uploads/company/' . $work_order->owned_by . '/work_order/' . $filename);

            if (File::exists($workOrderFile)) {
                unlink($workOrderFile);
            }

            $result = WorkOrder::where('id', $work_order->id)
                ->first()->update([
                    'file_attachment' => $filename,
                    'updated_by' => $request->user()->id
                ]);

            if( !$result ) {
                $flag = false;
            }

            if($flag) {
                DB::commit();

                $data->move($path, $filename);
    
                return response()->json(['success' => 'Work Order Attachment has been Updated']);
            }else{
                DB::rollBack();

                return response()->json(['error' => 'Work Order Attachment failed to update']);
            }

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

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function itemRequirements(Request $request, WorkOrder $work_order)
    {
        if ($request->ajax()) {

            $items = WOWPTaskcardItem::select(
                'id',
                'work_order_id',
                'work_package_id',
                'quantity',
                'description',
                'unit_json',
                'item_json',
                'taskcard_json'
            )
            ->where('work_order_id', $work_order->id);

            return Datatables::of($items)
                ->addColumn('unit_json', function($itemRow) {
                    return json_decode($itemRow->unit_json, true);
                })
                ->addColumn('item_json', function($itemRow) {
                    return json_decode($itemRow->item_json, true);
                })
                ->addColumn('taskcard_json', function($itemRow) {
                    return json_decode($itemRow->taskcard_json, true);
                })
                ->escapeColumns([])
                ->make();
        }

        abort(500);
    }
}

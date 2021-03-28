<?php

namespace Modules\PPC\Http\Controllers;

use Modules\PPC\Entities\TaskcardIntervalGroup;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TaskcardIntervalGroupController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(TaskcardIntervalGroup::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TaskcardIntervalGroup::all();
            
            return Datatables::of($data)
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<label class="label label-success">Active</label>';
                    } else{
                        return '<label class="label label-danger">Inactive</label>';
                    }
                })
                ->addColumn('creator_name', function($row){
                    return $row->creator->name ?? '-';
                })
                ->addColumn('updater_name', function($row){
                    return $row->updater->name ?? '-';
                })
                ->addColumn('action', function($row){
                    $noAuthorize = true;
                    if(Auth::user()->can('update', TaskcardIntervalGroup::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', TaskcardIntervalGroup::class)) {
                        $deleteable = true;
                        $deleteId = $row->id;
                        $noAuthorize = false;
                    }

                    if ($noAuthorize == false) {
                        return view('components.action-button', compact(['updateable', 'updateValue','deleteable', 'deleteId']));
                    }
                    else {
                        return '<p class="text-muted font-italic">Not Authorized</p>';
                    }
                    
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('ppc::pages.taskcard-interval-group.index');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'max:30', 'unique:taskcard_interval_groups,code'],
            'name' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        TaskcardIntervalGroup::create([
            'uuid' =>  Str::uuid(),

            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,

            'threshold_flight_hour' => $request->threshold_flight_hour,
            'threshold_flight_cycle' => $request->threshold_flight_cycle,
            'threshold_daily' => $request->threshold_daily,
            'threshold_daily_unit' => $threshold_daily_unit,
            'threshold_date' => $threshold_date,
            'repeat_flight_hour' => $request->repeat_flight_hour,
            'repeat_flight_cycle' => $request->repeat_flight_cycle,
            'repeat_daily' => $request->repeat_daily,
            'repeat_daily_unit' => $repeat_daily_unit,
            'repeat_date' => $repeat_date,
            'interval_control_method' => $request->interval_control_method,
            
            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Task Card Interval Group Data has been Added']);
    
    }

    public function update(Request $request, TaskcardIntervalGroup $TaskcardIntervalGroup)
    {
        $request->validate([
            'code' => ['required', 'max:30'],
            'name' => ['required', 'max:30'],
        ]);

        $currentRow = TaskcardIntervalGroup::where('id', $TaskcardIntervalGroup->id)
                                    ->first();

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        DB::beginTransaction();
        if ($currentRow->code == $request->code) {
            $currentRow->update([
                'name' => $request->name,
                'description' => $request->description,

                'threshold_flight_hour' => $request->threshold_flight_hour,
                'threshold_flight_cycle' => $request->threshold_flight_cycle,
                'threshold_daily' => $request->threshold_daily,
                'threshold_daily_unit' => $threshold_daily_unit,
                'threshold_date' => $threshold_date,
                'repeat_flight_hour' => $request->repeat_flight_hour,
                'repeat_flight_cycle' => $request->repeat_flight_cycle,
                'repeat_daily' => $request->repeat_daily,
                'repeat_daily_unit' => $repeat_daily_unit,
                'repeat_date' => $repeat_date,
                'interval_control_method' => $request->interval_control_method,
                
                'status' => $status,
                'updated_by' => Auth::user()->id,
            ]);
        }
        else {
            $currentRow->update([
                'code' => $request->code,
                'name' => $request->name,
                'description' => $request->description,

                'threshold_flight_hour' => $request->threshold_flight_hour,
                'threshold_flight_cycle' => $request->threshold_flight_cycle,
                'threshold_daily' => $request->threshold_daily,
                'threshold_daily_unit' => $threshold_daily_unit,
                'threshold_date' => $threshold_date,
                'repeat_flight_hour' => $request->repeat_flight_hour,
                'repeat_flight_cycle' => $request->repeat_flight_cycle,
                'repeat_daily' => $request->repeat_daily,
                'repeat_daily_unit' => $repeat_daily_unit,
                'repeat_date' => $repeat_date,
                'interval_control_method' => $request->interval_control_method,
                
                'status' => $status,
                'updated_by' => Auth::user()->id,
            ]);
        }
        DB::commit();
        return response()->json(['success' => 'Task Card Interval Group Data has been Updated']);
    }

    public function destroy(TaskcardIntervalGroup $TaskcardIntervalGroup)
    {
        $currentRow = TaskcardIntervalGroup::where('id', $TaskcardIntervalGroup->id)
                                    ->first();
        $currentRow->update([
            'deleted_by' => Auth::user()->id,
        ]);
        TaskcardIntervalGroup::destroy($TaskcardIntervalGroup->id);
        return response()->json(['success' => 'Task Card Interval Group Data has been Deleted']);
    }
}
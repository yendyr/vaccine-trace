<?php

namespace Modules\PPC\Http\Controllers;

use Modules\PPC\Entities\TaskcardTag;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TaskcardTagController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(TaskcardTag::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TaskcardTag::all();
            
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
                // ->addColumn('threshold_interval', function($row){
                //     $threshold_interval = '';
                //     if ($row->threshold_flight_hour) {
                //         $threshold_interval .= $row->threshold_flight_hour . ' FH / ';
                //     }
                //     else {
                //         $threshold_interval .= '- FH / ';
                //     }

                //     if ($row->threshold_flight_cycle) {
                //         $threshold_interval .= $row->threshold_flight_cycle . ' FC / ';
                //     }
                //     else {
                //         $threshold_interval .= '- FC / ';
                //     }

                //     if ($row->threshold_daily) {
                //         $threshold_interval .= $row->threshold_daily . ' ' . $row->threshold_daily_unit . '(s)';
                //     }
                //     else {
                //         $threshold_interval .= '- Day';
                //     }

                //     return $threshold_interval;
                // })
                // ->addColumn('repeat_interval', function($row){
                //     $repeat_interval = '';
                //     if ($row->repeat_flight_hour) {
                //         $repeat_interval .= $row->repeat_flight_hour . ' FH / ';
                //     }
                //     else {
                //         $repeat_interval .= '- FH / ';
                //     }

                //     if ($row->repeat_flight_cycle) {
                //         $repeat_interval .= $row->repeat_flight_cycle . ' FC / ';
                //     }
                //     else {
                //         $repeat_interval .= '- FC / ';
                //     }

                //     if ($row->repeat_daily) {
                //         $repeat_interval .= $row->repeat_daily . ' ' . $row->repeat_daily_unit . '(s)';
                //     }
                //     else {
                //         $repeat_interval .= '- Day';
                //     }

                //     return $repeat_interval;
                // })
                ->addColumn('action', function($row){
                    $noAuthorize = true;
                    if(Auth::user()->can('update', TaskcardTag::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', TaskcardTag::class)) {
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
            'code' => ['required', 'max:30', 'unique:taskcard_tags,code'],
            'name' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        // if ($request->threshold_daily_unit) {
        //     $threshold_daily_unit = $request->threshold_daily_unit;
        // } 
        // else {
        //     $threshold_daily_unit = 'Year';
        // }

        // if ($request->repeat_daily_unit) {
        //     $repeat_daily_unit = $request->repeat_daily_unit;
        // } 
        // else {
        //     $repeat_daily_unit = 'Year';
        // }

        // $threshold_date = $request->threshold_date;
        // $repeat_date = $request->repeat_date;

        TaskcardTag::create([
            'uuid' =>  Str::uuid(),

            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,

            // 'threshold_flight_hour' => $request->threshold_flight_hour,
            // 'threshold_flight_cycle' => $request->threshold_flight_cycle,
            // 'threshold_daily' => $request->threshold_daily,
            // 'threshold_daily_unit' => $threshold_daily_unit,
            // 'threshold_date' => $threshold_date,
            // 'repeat_flight_hour' => $request->repeat_flight_hour,
            // 'repeat_flight_cycle' => $request->repeat_flight_cycle,
            // 'repeat_daily' => $request->repeat_daily,
            // 'repeat_daily_unit' => $repeat_daily_unit,
            // 'repeat_date' => $repeat_date,
            // 'interval_control_method' => $request->interval_control_method,
            
            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Task Card Tag Data has been Added']);
    
    }

    public function update(Request $request, TaskcardTag $TaskcardTag)
    {
        $request->validate([
            'code' => ['required', 'max:30'],
            'name' => ['required', 'max:30'],
        ]);

        $currentRow = TaskcardTag::where('id', $TaskcardTag->id)
                                    ->first();

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        // if ($request->threshold_daily_unit) {
        //     $threshold_daily_unit = $request->threshold_daily_unit;
        // } 
        // else {
        //     $threshold_daily_unit = 'Year';
        // }

        // if ($request->repeat_daily_unit) {
        //     $repeat_daily_unit = $request->repeat_daily_unit;
        // } 
        // else {
        //     $repeat_daily_unit = 'Year';
        // }

        // $threshold_date = $request->threshold_date;
        // $repeat_date = $request->repeat_date;

        DB::beginTransaction();
        if ($currentRow->code == $request->code) {
            $currentRow->update([
                'name' => $request->name,
                'description' => $request->description,

                // 'threshold_flight_hour' => $request->threshold_flight_hour,
                // 'threshold_flight_cycle' => $request->threshold_flight_cycle,
                // 'threshold_daily' => $request->threshold_daily,
                // 'threshold_daily_unit' => $threshold_daily_unit,
                // 'threshold_date' => $threshold_date,
                // 'repeat_flight_hour' => $request->repeat_flight_hour,
                // 'repeat_flight_cycle' => $request->repeat_flight_cycle,
                // 'repeat_daily' => $request->repeat_daily,
                // 'repeat_daily_unit' => $repeat_daily_unit,
                // 'repeat_date' => $repeat_date,
                // 'interval_control_method' => $request->interval_control_method,
                
                'status' => $status,
                'updated_by' => Auth::user()->id,
            ]);
        }
        else {
            $currentRow->update([
                'code' => $request->code,
                'name' => $request->name,
                'description' => $request->description,

                // 'threshold_flight_hour' => $request->threshold_flight_hour,
                // 'threshold_flight_cycle' => $request->threshold_flight_cycle,
                // 'threshold_daily' => $request->threshold_daily,
                // 'threshold_daily_unit' => $threshold_daily_unit,
                // 'threshold_date' => $threshold_date,
                // 'repeat_flight_hour' => $request->repeat_flight_hour,
                // 'repeat_flight_cycle' => $request->repeat_flight_cycle,
                // 'repeat_daily' => $request->repeat_daily,
                // 'repeat_daily_unit' => $repeat_daily_unit,
                // 'repeat_date' => $repeat_date,
                // 'interval_control_method' => $request->interval_control_method,
                
                'status' => $status,
                'updated_by' => Auth::user()->id,
            ]);
        }
        DB::commit();
        return response()->json(['success' => 'Task Card Tag Data has been Updated']);
    }

    public function destroy(TaskcardTag $TaskcardTag)
    {
        $currentRow = TaskcardTag::where('id', $TaskcardTag->id)
                                    ->first();
        $currentRow->update([
            'deleted_by' => Auth::user()->id,
        ]);
        TaskcardTag::destroy($TaskcardTag->id);
        return response()->json(['success' => 'Task Card Tag Data has been Deleted']);
    }

    public function select2(Request $request)
    {
        $search = $request->q;
        $query = TaskcardTag::orderby('name','asc')
                            ->select('code','id','name')
                            ->where('status', 1);
        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%');
        }
        $TaskcardTags = $query->get();

        $response = [];
        foreach($TaskcardTags as $TaskcardTag){
            $response['results'][] = [
                "id" => $TaskcardTag->id,
                "text" => $TaskcardTag->code . ' | ' . $TaskcardTag->name
            ];
        }
        return response()->json($response);
    }
}
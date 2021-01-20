<?php

namespace Modules\PPC\Http\Controllers;

use Modules\PPC\Entities\Taskcard;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TaskcardController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Taskcard::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Taskcard::all();
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
                    if(Auth::user()->can('update', AircraftType::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', AircraftType::class)) {
                        $deleteable = true;
                        $deleteId = $row->id;
                        $noAuthorize = false;
                    }

                    if ($noAuthorize == false) {
                        return view('components.action-button', compact(['updateable', 'updateValue','deleteable', 'deleteId']));
                    }
                    else {
                        return '<p class="text-muted">Not Authorized</p>';
                    }
                    
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('ppc::pages.taskcard.index');
    }

    public function create()
    {
        return view('ppc::pages.taskcard.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'mpd_number' => ['required', 'max:30'],
            'title' => ['required', 'max:30'],
            'taskcard_group_id' => ['required', 'max:30'],
            'taskcard_type_id' => ['required', 'max:30'],
            'interval_control_method' => ['required', 'max:30'],

            'threshold_flight_hour' => ['required_without_all:threshold_flight_cycle,threshold_day_count,threshold_date'],
            'threshold_flight_cycle' => ['required_without_all:threshold_flight_hour,threshold_day_count,threshold_date'],
            'threshold_day_count' => ['required_without_all:threshold_flight_hour,threshold_flight_cycle,threshold_date'],
            'threshold_date' => ['required_without_all:threshold_flight_hour,threshold_flight_cycle,threshold_day_count'],

            'repeat_flight_hour' => ['required_without_all:repeat_flight_cycle,repeat_day_count,repeat_date'],
            'repeat_flight_cycle' => ['required_without_all:repeat_flight_hour,repeat_day_count,repeat_date'],
            'repeat_day_count' => ['required_without_all:repeat_flight_hour,repeat_flight_cycle,repeat_date'],
            'repeat_date' => ['required_without_all:repeat_flight_hour,repeat_flight_cycle,repeat_day_count'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        Taskcard::create([
            'uuid' =>  Str::uuid(),
            'mpd_number' => $request->mpd_number,
            'title' => $request->title,
            'taskcard_group_id' => $request->taskcard_group_id,
            'taskcard_type_id' => $request->taskcard_type_id,
            'threshold_flight_hour' => $request->threshold_flight_hour,
            'threshold_flight_cycle' => $request->threshold_flight_cycle,
            'threshold_day_count' => $request->threshold_day_count,
            'threshold_date' => $request->threshold_date,
            'repeat_flight_hour' => $request->repeat_flight_hour,
            'repeat_flight_cycle' => $request->repeat_flight_cycle,
            'repeat_day_count' => $request->repeat_day_count,
            'repeat_date' => $request->repeat_date,
            'interval_control_method' => $request->interval_control_method,

            'company_number' => $request->company_number,
            'ata' => $request->ata,
            'version' => $request->version,
            'revision' => $request->revision,
            'effectivity' => $request->effectivity,
            'taskcard_workarea_id' => $request->taskcard_workarea_id,
            'source' => $request->source,
            'reference' => $request->reference,
            'file_attachment' => $request->file_attachment,
            'scheduled_priority' => $request->scheduled_priority,
            'recurrence' => $request->recurrence,

            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Task Card Data has been Added']);
    
    }

    public function show(Taskcard $Taskcard)
    {
        return view('ppc::pages.taskcard.show');
    }

    public function edit(Taskcard $Taskcard)
    {
        return view('ppc::pages.taskcard.edit', compact('Taskcard'));
    }

    public function update(Request $request, Taskcard $Taskcard)
    {
        $request->validate([
            'code' => ['required', 'max:30'],
            'name' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        $currentRow = AircraftType::where('id', $AircraftType->id)->first();
        if ( $currentRow->code == $request->code) {
            $currentRow
                ->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'manufacturer_id' => $request->manufacturer_id,
                    'status' => $status,
                    'updated_by' => Auth::user()->id,
            ]);
        }
        else {
            $currentRow
                ->update([
                    'code' => $request->code,
                    'name' => $request->name,
                    'description' => $request->description,
                    'manufacturer_id' => $request->manufacturer_id,
                    'status' => $status,
                    'updated_by' => Auth::user()->id,
            ]);
        }
        return response()->json(['success' => 'Task Card Data has been Updated']);
    
    }

    public function destroy(Taskcard $Taskcard)
    {
        $currentRow = Taskcard::where('id', $Taskcard->id)->first();
        $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        Taskcard::destroy($Taskcard->id);
        return response()->json(['success' => 'Task Card Data has been Deleted']);
    }

    // public function select2(Request $request)
    // {
    //     $search = $request->q;

    //     $query = AircraftType::orderby('name','asc')
    //                 ->select('id','name')
    //                 ->where('status', 1);

    //     if($search != ''){
    //         $query = $query->where('name', 'like', '%' .$search. '%');
    //     }
    //     $AircraftTypes = $query->get();

    //     $response = [];
    //     foreach($AircraftTypes as $AircraftType){
    //         $response['results'][] = [
    //             "id"=>$AircraftType->id,
    //             "text"=>$AircraftType->name
    //         ];
    //     }

    //     return response()->json($response);
    // }

}
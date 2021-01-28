<?php

namespace Modules\PPC\Http\Controllers;

use Modules\PPC\Entities\Taskcard;
use Modules\PPC\Entities\TaskcardDetailAircraftType;
use Modules\PPC\Entities\TaskcardDetailAccess;
use Modules\PPC\Entities\TaskcardDetailZone;
use Modules\PPC\Entities\TaskcardDetailDocumentLibrary;
use Modules\PPC\Entities\TaskcardDetailAffectedManual;
use Modules\PPC\Entities\TaskcardDetailInstruction;
use Modules\PPC\Entities\TaskcardDetailInstructionSkill;

use Illuminate\Support\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
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
            $data = Taskcard::with([
                    'taskcard_group:id,name',
                    'taskcard_type:id,name',
                    'taskcard_workarea:id,name',
                    'aircraft_types:id,name',
                    'accesses:id,name',
                    'zones:id,name',
                    'document_libraries:id,name',
                    'affected_manuals:id,name',
                    ]);
            return Datatables::of($data)
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<label class="label label-success">Active</label>';
                    } else{
                        return '<label class="label label-danger">Inactive</label>';
                    }
                })
                ->addColumn('instruction_count', function($row){
                    return '<label class="label label-success">' . $row->instruction_details()->count() . '</label>';
                })
                ->addColumn('manhours_total', function($row){
                    return '<label class="label label-primary">' . $row->instruction_details()->sum('manhours_estimation') . '</label>';
                })
                ->addColumn('aircraft_type_name', function($row){
                    $aircraft_type_name = null;
                    foreach ($row->aircraft_types as $aircraft_type) {
                        $aircraft_type_name .= $aircraft_type->name . ', ';
                    }
                    return $aircraft_type_name;
                })
                ->addColumn('skills', function($row){
                    $skillsArray = array();
                    $skill_name = '';

                    $TaskcardDetailInstructions = TaskcardDetailInstruction::where('taskcard_id', $row->id)->get();
                    
                    foreach ($TaskcardDetailInstructions as $TaskcardDetailInstruction) {
                        $TaskcardDetailInstructionSkills = TaskcardDetailInstructionSkill::where('taskcard_detail_instruction_id', $TaskcardDetailInstruction->id)->get();

                        foreach ($TaskcardDetailInstructionSkills as $TaskcardDetailInstructionSkill) {
                            if (!in_array($TaskcardDetailInstructionSkill->skill->name, $skillsArray)) {
                                $skillsArray[] = $TaskcardDetailInstructionSkill->skill->name;
                            }
                        }
                    }

                    foreach ($skillsArray as $skill) {
                        $skill_name .= $skill . ', ';
                    }
                    
                    return $skill_name;
                })
                ->addColumn('creator_name', function($row){
                    return $row->creator->name ?? '-';
                })
                ->addColumn('updater_name', function($row){
                    return $row->updater->name ?? '-';
                })
                ->addColumn('action', function($row){
                    $noAuthorize = true;
                    if(Auth::user()->can('update', Taskcard::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', Taskcard::class)) {
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
            'compliance' => ['required'],
            'interval_control_method' => ['required', 'max:30'],

            'threshold_flight_hour' => ['required_without_all:threshold_flight_cycle,threshold_daily,threshold_date'],
            'threshold_flight_cycle' => ['required_without_all:threshold_flight_hour,threshold_daily,threshold_date'],
            'threshold_daily' => ['required_without_all:threshold_flight_hour,threshold_flight_cycle,threshold_date'],
            'threshold_date' => ['required_without_all:threshold_flight_hour,threshold_flight_cycle,threshold_daily'],

            'repeat_flight_hour' => ['required_without_all:repeat_flight_cycle,repeat_daily,repeat_date'],
            'repeat_flight_cycle' => ['required_without_all:repeat_flight_hour,repeat_daily,repeat_date'],
            'repeat_daily' => ['required_without_all:repeat_flight_hour,repeat_flight_cycle,repeat_date'],
            'repeat_date' => ['required_without_all:repeat_flight_hour,repeat_flight_cycle,repeat_daily'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        if ($request->threshold_date) {
            $threshold_date = Carbon::createFromFormat('m/d/Y', $request->threshold_date)->format('Y-m-d');
        }
        else {
            $threshold_date = null;
        }

        if ($request->repeat_date) {
            $repeat_date = Carbon::createFromFormat('m/d/Y', $request->repeat_date)->format('Y-m-d');
        }
        else {
            $repeat_date = null;
        }

        if ($request->issued_date) {
            $issued_date = Carbon::createFromFormat('m/d/Y', $request->issued_date)->format('Y-m-d');
        }
        else {
            $issued_date = null;
        }

        DB::beginTransaction();
        $Taskcard = Taskcard::create([
            'uuid' =>  Str::uuid(),
            'mpd_number' => $request->mpd_number,
            'title' => $request->title,
            'taskcard_group_id' => $request->taskcard_group_id,
            'taskcard_type_id' => $request->taskcard_type_id,
            'compliance' => $request->compliance,
            'threshold_flight_hour' => $request->threshold_flight_hour,
            'threshold_flight_cycle' => $request->threshold_flight_cycle,
            'threshold_daily' => $request->threshold_daily,
            'threshold_daily_unit' => $request->threshold_daily_unit,
            'threshold_date' => $threshold_date,
            'repeat_flight_hour' => $request->repeat_flight_hour,
            'repeat_flight_cycle' => $request->repeat_flight_cycle,
            'repeat_daily' => $request->repeat_daily,
            'repeat_daily_unit' => $request->repeat_daily_unit,
            'repeat_date' => $repeat_date,
            'interval_control_method' => $request->interval_control_method,

            'company_number' => $request->company_number,
            'ata' => $request->ata,
            'issued_date' => $issued_date,
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
            'status' => 1,
            'created_by' => $request->user()->id,
        ]);

        if ($request->aircraft_type_id) {
            foreach ($request->aircraft_type_id as $aircraft_type_id) {
                $Taskcard->aircraft_type_details()
                        ->save(new TaskcardDetailAircraftType([
                            'uuid' => Str::uuid(),
                            'aircraft_type_id' => $aircraft_type_id,
                            'owned_by' => $request->user()->company_id,
                            'status' => 1,
                            'created_by' => $request->user()->id,
                        ]));
            }
        }

        if ($request->taskcard_access_id) {
            foreach ($request->taskcard_access_id as $taskcard_access_id) {
                $Taskcard->access_details()
                        ->save(new TaskcardDetailAccess([
                            'uuid' => Str::uuid(),
                            'taskcard_access_id' => $taskcard_access_id,
                            'owned_by' => $request->user()->company_id,
                            'status' => 1,
                            'created_by' => $request->user()->id,
                        ]));
            }
        }

        if ($request->taskcard_zone_id) {
            foreach ($request->taskcard_zone_id as $taskcard_zone_id) {
                $Taskcard->zone_details()
                        ->save(new TaskcardDetailZone([
                            'uuid' => Str::uuid(),
                            'taskcard_zone_id' => $taskcard_zone_id,
                            'owned_by' => $request->user()->company_id,
                            'status' => 1,
                            'created_by' => $request->user()->id,
                        ]));
            }
        }

        if ($request->taskcard_document_library_id) {
            foreach ($request->taskcard_document_library_id as $taskcard_document_library_id) {
                $Taskcard->document_library_details()
                        ->save(new TaskcardDetailDocumentLibrary([
                            'uuid' => Str::uuid(),
                            'taskcard_document_library_id' => $taskcard_document_library_id,
                            'owned_by' => $request->user()->company_id,
                            'status' => 1,
                            'created_by' => $request->user()->id,
                        ]));
            }
        }

        if ($request->taskcard_affected_manual_id) {
            foreach ($request->taskcard_affected_manual_id as $taskcard_affected_manual_id) {
                $Taskcard->affected_manual_details()
                        ->save(new TaskcardDetailAffectedManual([
                            'uuid' => Str::uuid(),
                            'taskcard_affected_manual_id' => $taskcard_affected_manual_id,
                            'owned_by' => $request->user()->company_id,
                            'status' => 1,
                            'created_by' => $request->user()->id,
                        ]));
            }
        }
        DB::commit();

        return response()->json(['success' => 'Task Card Data has been Added']);
    
    }

    public function show(Taskcard $Taskcard)
    {
        return view('ppc::pages.taskcard.show', compact('Taskcard'));
    }

    public function update(Request $request, Taskcard $Taskcard)
    {
        $request->validate([
            'mpd_number' => ['required', 'max:30'],
            'title' => ['required', 'max:30'],
            'taskcard_group_id' => ['required', 'max:30'],
            'taskcard_type_id' => ['required', 'max:30'],
            'compliance' => ['required'],
            'interval_control_method' => ['required', 'max:30'],

            'threshold_flight_hour' => ['required_without_all:threshold_flight_cycle,threshold_daily,threshold_date'],
            'threshold_flight_cycle' => ['required_without_all:threshold_flight_hour,threshold_daily,threshold_date'],
            'threshold_daily' => ['required_without_all:threshold_flight_hour,threshold_flight_cycle,threshold_date'],
            'threshold_date' => ['required_without_all:threshold_flight_hour,threshold_flight_cycle,threshold_daily'],

            'repeat_flight_hour' => ['required_without_all:repeat_flight_cycle,repeat_daily,repeat_date'],
            'repeat_flight_cycle' => ['required_without_all:repeat_flight_hour,repeat_daily,repeat_date'],
            'repeat_daily' => ['required_without_all:repeat_flight_hour,repeat_flight_cycle,repeat_date'],
            'repeat_date' => ['required_without_all:repeat_flight_hour,repeat_flight_cycle,repeat_daily'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        if ($request->threshold_date) {
            $threshold_date = Carbon::createFromFormat('m/d/Y', $request->threshold_date)->format('Y-m-d');
        }
        else {
            $threshold_date = null;
        }

        if ($request->repeat_date) {
            $repeat_date = Carbon::createFromFormat('m/d/Y', $request->repeat_date)->format('Y-m-d');
        }
        else {
            $repeat_date = null;
        }

        if ($request->issued_date) {
            $issued_date = Carbon::createFromFormat('m/d/Y', $request->issued_date)->format('Y-m-d');
        }
        else {
            $issued_date = null;
        }

        DB::beginTransaction();
        $currentRow = Taskcard::where('id', $Taskcard->id)->first();
        $currentRow
            ->update([
                'mpd_number' => $request->mpd_number,
                'title' => $request->title,
                'taskcard_group_id' => $request->taskcard_group_id,
                'taskcard_type_id' => $request->taskcard_type_id,
                'compliance' => $request->compliance,
                'threshold_flight_hour' => $request->threshold_flight_hour,
                'threshold_flight_cycle' => $request->threshold_flight_cycle,
                'threshold_daily' => $request->threshold_daily,
                'threshold_daily_unit' => $request->threshold_daily_unit,
                'threshold_date' => $threshold_date,
                'repeat_flight_hour' => $request->repeat_flight_hour,
                'repeat_flight_cycle' => $request->repeat_flight_cycle,
                'repeat_daily' => $request->repeat_daily,
                'repeat_daily_unit' => $request->repeat_daily_unit,
                'repeat_date' => $repeat_date,
                'interval_control_method' => $request->interval_control_method,

                'company_number' => $request->company_number,
                'ata' => $request->ata,
                'issued_date' => $issued_date,
                'version' => $request->version,
                'revision' => $request->revision,
                'effectivity' => $request->effectivity,
                'taskcard_workarea_id' => $request->taskcard_workarea_id,
                'source' => $request->source,
                'reference' => $request->reference,
                'file_attachment' => $request->file_attachment,
                'scheduled_priority' => $request->scheduled_priority,
                'recurrence' => $request->recurrence,

                'status' => 1,
                'updated_by' => $request->user()->id,
        ]);

        if ($request->aircraft_type_id) {
            $Taskcard->aircraft_type_details()->forceDelete();

            foreach ($request->aircraft_type_id as $aircraft_type_id) {
                $Taskcard->aircraft_type_details()
                        ->save(new TaskcardDetailAircraftType([
                            'uuid' => Str::uuid(),
                            'aircraft_type_id' => $aircraft_type_id,
                            'owned_by' => $request->user()->company_id,
                            'status' => 1,
                            'created_by' => $request->user()->id,
                        ]));
            }
        }

        if ($request->taskcard_access_id) {
            $Taskcard->access_details()->forceDelete();

            foreach ($request->taskcard_access_id as $taskcard_access_id) {
                $Taskcard->access_details()
                        ->save(new TaskcardDetailAccess([
                            'uuid' => Str::uuid(),
                            'taskcard_access_id' => $taskcard_access_id,
                            'owned_by' => $request->user()->company_id,
                            'status' => 1,
                            'created_by' => $request->user()->id,
                        ]));
            }
        }

        if ($request->taskcard_zone_id) {
            $Taskcard->zone_details()->forceDelete();

            foreach ($request->taskcard_zone_id as $taskcard_zone_id) {
                $Taskcard->zone_details()
                        ->save(new TaskcardDetailZone([
                            'uuid' => Str::uuid(),
                            'taskcard_zone_id' => $taskcard_zone_id,
                            'owned_by' => $request->user()->company_id,
                            'status' => 1,
                            'created_by' => $request->user()->id,
                        ]));
            }
        }

        if ($request->taskcard_document_library_id) {
            $Taskcard->document_library_details()->forceDelete();

            foreach ($request->taskcard_document_library_id as $taskcard_document_library_id) {
                $Taskcard->document_library_details()
                        ->save(new TaskcardDetailDocumentLibrary([
                            'uuid' => Str::uuid(),
                            'taskcard_document_library_id' => $taskcard_document_library_id,
                            'owned_by' => $request->user()->company_id,
                            'status' => 1,
                            'created_by' => $request->user()->id,
                        ]));
            }
        }

        if ($request->taskcard_affected_manual_id) {
            $Taskcard->affected_manual_details()->forceDelete();

            foreach ($request->taskcard_affected_manual_id as $taskcard_affected_manual_id) {
                $Taskcard->affected_manual_details()
                        ->save(new TaskcardDetailAffectedManual([
                            'uuid' => Str::uuid(),
                            'taskcard_affected_manual_id' => $taskcard_affected_manual_id,
                            'owned_by' => $request->user()->company_id,
                            'status' => 1,
                            'created_by' => $request->user()->id,
                        ]));
            }
        }

        DB::commit();

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

    public function fileUpload(Request $request, Taskcard $Taskcard)
    {
        if($request->ajax()) {
            $data = $request->file('file');
            $extension = $data->getClientOriginalExtension();
            $filename = 'taskcard_attachment_' . $Taskcard->id . '.' . $extension;
            $path = public_path('uploads/company/' . $Taskcard->owned_by . '/taskcard/');
            
            $usersImage = public_path('uploads/company/' . $Taskcard->owned_by . '/taskcard/' . $filename);

            if (File::exists($usersImage)) {
                unlink($usersImage);
                $successText = 'Task Card Attachment has been Updated';
            } else {
                $successText = 'Task Card Attachment has been Updated';
            }

            Taskcard::where('id', $Taskcard->id)
                ->update([
                    'file_attachment' => $filename,
                    'updated_by' => $request->user()->id
                ]);

            $data->move($path, $filename);

            return response()->json(['success' => $successText]);
        }
    }

}
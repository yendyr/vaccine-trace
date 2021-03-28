<?php

namespace Modules\PPC\Http\Controllers;

use Modules\PPC\Entities\Taskcard;
use Modules\PPC\Entities\TaskcardGroup;
use Modules\PPC\Entities\TaskcardDetailAircraftType;
use Modules\PPC\Entities\TaskcardDetailAffectedItem;
use Modules\PPC\Entities\TaskcardDetailIntervalGroup;
use Modules\PPC\Entities\TaskcardDetailAccess;
use Modules\PPC\Entities\TaskcardDetailZone;
use Modules\PPC\Entities\TaskcardDetailDocumentLibrary;
use Modules\PPC\Entities\TaskcardDetailAffectedManual;
use Modules\PPC\Entities\TaskcardDetailInstruction;
use Modules\PPC\Entities\TaskcardDetailInstructionSkill;

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
            if($request->aircraft_type_id != null && $request->maintenance_program_id != null) {
                $data = Taskcard::whereHas('aircraft_types',
                            function($aircraft_types) use ($request) {
                                $aircraft_types->where('aircraft_types.id', $request->aircraft_type_id);
                            })
                            ->leftJoin('maintenance_program_details', 'taskcards.id', '=', 'maintenance_program_details.taskcard_id')
                            ->where('maintenance_program_details.maintenance_program_id', $request->maintenance_program_id)
                            ->with([
                                'taskcard_group:id,name,parent_id',
                                'interval_groups:id,code,name',
                                'taskcard_type:id,name',
                                'taskcard_workarea:id,name',
                                'aircraft_types:id,name',
                                'affected_items:id,code,name',
                                'accesses:id,name',
                                'zones:id,name',
                                'document_libraries:id,name',
                                'affected_manuals:id,name',
                            ]);
            }
            else if($request->aircraft_type_id) {
                $data = Taskcard::whereHas('aircraft_types',
                            function($aircraft_types) use ($request) {
                                $aircraft_types->where('aircraft_types.id', $request->aircraft_type_id);
                            })
                            ->with([
                                'taskcard_group:id,name,parent_id',
                                'interval_groups:id,code,name',
                                'taskcard_type:id,name',
                                'taskcard_workarea:id,name',
                                'aircraft_types:id,name',
                                'affected_items:id,code,name',
                                'accesses:id,name',
                                'zones:id,name',
                                'document_libraries:id,name',
                                'affected_manuals:id,name',
                            ]);
            }
            else {
                $data = Taskcard::with([
                    'taskcard_group:id,name,parent_id',
                    'interval_groups:id,code,name',
                    'taskcard_type:id,name',
                    'taskcard_workarea:id,name',
                    'aircraft_types:id,name',
                    'affected_items:id,code,name',
                    'accesses:id,name',
                    'zones:id,name',
                    'document_libraries:id,name',
                    'affected_manuals:id,name',
                    ]);
            }
            
            return Datatables::of($data)
                ->addColumn('group_structure', function($row) {
                    if ($row->taskcard_group_id) {
                        $currentRow = TaskcardGroup::where('id', $row->taskcard_group_id)->withTrashed()->first();
                        $group_structure = '';

                        while (true) {
                            if ($currentRow) {
                                $group_structure = $currentRow->name . ' -> ' . $group_structure;
                                $currentRow = TaskcardGroup::where('id', $currentRow->parent_id)->first();
                            }
                            else {
                                break;
                            }
                        }
                        $group_structure = Str::beforeLast($group_structure, '->');
                        return $group_structure;
                    } 
                    else {
                        return '-';
                    }
                })
                ->addColumn('status', function($row){
                    if ($row->status == 1) {
                        return '<label class="label label-success">Active</label>';
                    } 
                    else {
                        return '<label class="label label-danger">Inactive</label>';
                    }
                })
                ->addColumn('interval_group', function($row){
                    $interval_group_name = null;
                    foreach ($row->interval_groups as $interval_group) {
                        $interval_group_name .= $interval_group->name . ', ';
                    }

                    $interval_group_name = Str::beforeLast($interval_group_name, ',');
                    return $interval_group_name;
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

                    $aircraft_type_name = Str::beforeLast($aircraft_type_name, ',');
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
                    
                    $skill_name = Str::beforeLast($skill_name, ',');
                    return $skill_name;
                })
                ->addColumn('threshold_interval', function($row){
                    $threshold_interval = '';
                    if ($row->threshold_flight_hour) {
                        $threshold_interval .= $row->threshold_flight_hour . ' FH / ';
                    }
                    else {
                        $threshold_interval .= '- FH / ';
                    }

                    if ($row->threshold_flight_cycle) {
                        $threshold_interval .= $row->threshold_flight_cycle . ' FC / ';
                    }
                    else {
                        $threshold_interval .= '- FC / ';
                    }

                    if ($row->threshold_daily) {
                        $threshold_interval .= $row->threshold_daily . ' ' . $row->threshold_daily_unit . '(s)';
                    }
                    else {
                        $threshold_interval .= '- Day';
                    }

                    return $threshold_interval;
                })
                ->addColumn('repeat_interval', function($row){
                    $repeat_interval = '';
                    if ($row->repeat_flight_hour) {
                        $repeat_interval .= $row->repeat_flight_hour . ' FH / ';
                    }
                    else {
                        $repeat_interval .= '- FH / ';
                    }

                    if ($row->repeat_flight_cycle) {
                        $repeat_interval .= $row->repeat_flight_cycle . ' FC / ';
                    }
                    else {
                        $repeat_interval .= '- FC / ';
                    }

                    if ($row->repeat_daily) {
                        $repeat_interval .= $row->repeat_daily . ' ' . $row->repeat_daily_unit . '(s)';
                    }
                    else {
                        $repeat_interval .= '- Day';
                    }

                    return $repeat_interval;
                })
                ->addColumn('creator_name', function($row){
                    return $row->creator->name ?? '-';
                })
                ->addColumn('updater_name', function($row){
                    return $row->updater->name ?? '-';
                })
                ->addColumn('action', function($row) use ($request) {
                    if(!$request->aircraft_type_id) {
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
                            return '<p class="text-muted font-italic">Not Authorized</p>';
                        }
                    }
                    else if($request->create_maintenance_program) {
                        $usable = true;
                        $idToUse = $row->id;
                        return view('components.action-button', compact(['usable', 'idToUse']));
                    }
                })
                ->escapeColumns([])
                ->make(true);
        }
        if(!$request->aircraft_type_id) {
            return view('ppc::pages.taskcard.index');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'mpd_number' => ['required', 'max:30'],
            'title' => ['required', 'max:100'],
            'taskcard_group_id' => ['required', 'max:30'],
            'taskcard_type_id' => ['required', 'max:30'],
            'compliance' => ['required'],
            'interval_control_method' => ['required', 'max:30'],

            'aircraft_type_id' => ['required_without_all:item_id'],
            'affected_item_id' => ['required_without_all:aircraft_type_id'],

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

        if ($request->threshold_daily_unit) {
            $threshold_daily_unit = $request->threshold_daily_unit;
        } 
        else {
            $threshold_daily_unit = 'Year';
        }

        if ($request->repeat_daily_unit) {
            $repeat_daily_unit = $request->repeat_daily_unit;
        } 
        else {
            $repeat_daily_unit = 'Year';
        }

        if ($request->scheduled_priority) {
            $scheduled_priority = $request->scheduled_priority;
        } 
        else {
            $scheduled_priority = 'As Scheduled';
        }

        if ($request->recurrence) {
            $recurrence = $request->recurrence;
        } 
        else {
            $recurrence = 'As Required';
        }

        $threshold_date = $request->threshold_date;
        $repeat_date = $request->repeat_date;
        $issued_date = $request->issued_date;
        
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
            'threshold_daily_unit' => $threshold_daily_unit,
            'threshold_date' => $threshold_date,
            'repeat_flight_hour' => $request->repeat_flight_hour,
            'repeat_flight_cycle' => $request->repeat_flight_cycle,
            'repeat_daily' => $request->repeat_daily,
            'repeat_daily_unit' => $repeat_daily_unit,
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
            'scheduled_priority' => $scheduled_priority,
            'recurrence' => $recurrence,

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

        if ($request->affected_item_id) {
            foreach ($request->affected_item_id as $affected_item_id) {
                $Taskcard->affected_item_details()
                    ->save(new TaskcardDetailAffectedItem([
                        'uuid' => Str::uuid(),
                        'affected_item_id' => $affected_item_id,
                        'owned_by' => $request->user()->company_id,
                        'status' => 1,
                        'created_by' => $request->user()->id,
                    ]));
            }
        }

        if ($request->interval_group_id) {
            foreach ($request->interval_group_id as $interval_group_id) {
                $Taskcard->interval_group_details()
                    ->save(new TaskcardDetailIntervalGroup([
                        'uuid' => Str::uuid(),
                        'interval_group_id' => $interval_group_id,
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
            'title' => ['required', 'max:100'],
            'taskcard_group_id' => ['required', 'max:30'],
            'taskcard_type_id' => ['required', 'max:30'],
            'compliance' => ['required'],
            'interval_control_method' => ['required', 'max:30'],

            'aircraft_type_id' => ['required_without_all:item_id'],
            'affected_item_id' => ['required_without_all:aircraft_type_id'],

            // 'threshold_flight_hour' => ['required_without_all:threshold_flight_cycle,threshold_daily,threshold_date'],
            // 'threshold_flight_cycle' => ['required_without_all:threshold_flight_hour,threshold_daily,threshold_date'],
            // 'threshold_daily' => ['required_without_all:threshold_flight_hour,threshold_flight_cycle,threshold_date'],
            // 'threshold_date' => ['required_without_all:threshold_flight_hour,threshold_flight_cycle,threshold_daily'],

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

        if ($request->threshold_daily_unit) {
            $threshold_daily_unit = $request->threshold_daily_unit;
        } 
        else {
            $threshold_daily_unit = 'Year';
        }

        if ($request->repeat_daily_unit) {
            $repeat_daily_unit = $request->repeat_daily_unit;
        } 
        else {
            $repeat_daily_unit = 'Year';
        }

        if ($request->scheduled_priority) {
            $scheduled_priority = $request->scheduled_priority;
        } 
        else {
            $scheduled_priority = 'As Scheduled';
        }

        if ($request->recurrence) {
            $recurrence = $request->recurrence;
        } 
        else {
            $recurrence = 'As Required';
        }

        $threshold_date = $request->threshold_date;
        
        $repeat_date = $request->repeat_date;
        
        $issued_date = $request->issued_date;

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
                'threshold_daily_unit' => $threshold_daily_unit,
                'threshold_date' => $threshold_date,
                'repeat_flight_hour' => $request->repeat_flight_hour,
                'repeat_flight_cycle' => $request->repeat_flight_cycle,
                'repeat_daily' => $request->repeat_daily,
                'repeat_daily_unit' => $repeat_daily_unit,
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
                'scheduled_priority' => $scheduled_priority,
                'recurrence' => $recurrence,

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

        if ($request->affected_item_id) {
            $Taskcard->affected_item_details()->forceDelete();
            foreach ($request->affected_item_id as $affected_item_id) {
                $Taskcard->affected_item_details()
                    ->save(new TaskcardDetailAffectedItem([
                        'uuid' => Str::uuid(),
                        'affected_item_id' => $affected_item_id,
                        'owned_by' => $request->user()->company_id,
                        'status' => 1,
                        'created_by' => $request->user()->id,
                    ]));
            }
        }
        else if ($request->affected_item_id == null) {
            $Taskcard->affected_item_details()->forceDelete();
        }

        if ($request->interval_group_id) {
            $Taskcard->interval_group_details()->forceDelete();
            foreach ($request->interval_group_id as $interval_group_id) {
                $Taskcard->interval_group_details()
                    ->save(new TaskcardDetailIntervalGroup([
                        'uuid' => Str::uuid(),
                        'interval_group_id' => $interval_group_id,
                        'owned_by' => $request->user()->company_id,
                        'status' => 1,
                        'created_by' => $request->user()->id,
                    ]));
            }
        }
        else if ($request->interval_group_id == null) {
            $Taskcard->interval_group_details()->forceDelete();
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
        else if ($request->taskcard_access_id == null) {
            $Taskcard->access_details()->forceDelete();
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
        else if ($request->taskcard_zone_id == null) {
            $Taskcard->zone_details()->forceDelete();
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
        else if ($request->taskcard_document_library_id == null) {
            $Taskcard->document_library_details()->forceDelete();
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
        else if ($request->taskcard_affected_manual_id == null) {
            $Taskcard->affected_manual_details()->forceDelete();
        }

        DB::commit();

        return response()->json(['success' => 'Task Card Data has been Updated']);
    }

    public function updateControlParameter(Request $request, Taskcard $Taskcard)
    {
        $request->validate([
            // 'threshold_flight_hour' => ['required_without_all:threshold_flight_cycle,threshold_daily,threshold_date'],
            // 'threshold_flight_cycle' => ['required_without_all:threshold_flight_hour,threshold_daily,threshold_date'],
            // 'threshold_daily' => ['required_without_all:threshold_flight_hour,threshold_flight_cycle,threshold_date'],
            // 'threshold_date' => ['required_without_all:threshold_flight_hour,threshold_flight_cycle,threshold_daily'],

            'repeat_flight_hour' => ['required_without_all:repeat_flight_cycle,repeat_daily,repeat_date'],
            'repeat_flight_cycle' => ['required_without_all:repeat_flight_hour,repeat_daily,repeat_date'],
            'repeat_daily' => ['required_without_all:repeat_flight_hour,repeat_flight_cycle,repeat_date'],
            'repeat_date' => ['required_without_all:repeat_flight_hour,repeat_flight_cycle,repeat_daily'],
        ]);

        if ($request->threshold_daily_unit) {
            $threshold_daily_unit = $request->threshold_daily_unit;
        } 
        else {
            $threshold_daily_unit = 'Year';
        }

        if ($request->repeat_daily_unit) {
            $repeat_daily_unit = $request->repeat_daily_unit;
        } 
        else {
            $repeat_daily_unit = 'Year';
        }

        $threshold_date = $request->threshold_date;
        $repeat_date = $request->repeat_date;

        $currentRow = Taskcard::where('id', $Taskcard->id)->first();
        $currentRow
            ->update([
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

                'updated_by' => $request->user()->id,
        ]);

        return response()->json(['success' => 'Task Card Control Parameter has been Updated']);
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
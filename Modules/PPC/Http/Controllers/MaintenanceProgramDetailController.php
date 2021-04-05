<?php

namespace Modules\PPC\Http\Controllers;

use Modules\PPC\Entities\MaintenanceProgram;
use Modules\PPC\Entities\MaintenanceProgramDetail;
use Modules\PPC\Entities\TaskcardGroup;
use Modules\PPC\Entities\TaskcardDetailInstruction;
use Modules\PPC\Entities\TaskcardDetailInstructionSkill;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class MaintenanceProgramDetailController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(MaintenanceProgram::class, 'maintenance_program_detail');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            if($request->maintenance_program_id) {
                $data = MaintenanceProgramDetail::where('maintenance_program_details.maintenance_program_id', $request->maintenance_program_id)
                                                ->with(['taskcard',
                                                        'taskcard.taskcard_type',
                                                        'taskcard.tags:id,code,name',
                                                        'maintenance_program',
                                                    ]);
                return Datatables::of($data)
                ->addColumn('group_structure', function($row) {
                    if ($row->taskcard->taskcard_group_id) {
                        $currentRow = TaskcardGroup::where('id', $row->taskcard->taskcard_group_id)->first();
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
                ->addColumn('tag', function($row){
                    $tag_name = null;
                    foreach ($row->taskcard->tags as $tag) {
                        $tag_name .= $tag->name . ', ';
                    }

                    $tag_name = Str::beforeLast($tag_name, ',');
                    return $tag_name;
                })
                ->addColumn('instruction_count', function($row){
                    return '<label class="label label-success">' . $row->taskcard->instruction_details()->count() . '</label>';
                })
                ->addColumn('manhours_total', function($row){
                    return '<label class="label label-primary">' . $row->taskcard->instruction_details()->sum('manhours_estimation') . '</label>';
                })
                ->addColumn('skills', function($row){
                    $skillsArray = array();
                    $skill_name = '';

                    $TaskcardDetailInstructions = TaskcardDetailInstruction::where('taskcard_id', $row->taskcard_id)->get();
                    
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
                    if ($row->taskcard->threshold_flight_hour) {
                        $threshold_interval .= $row->taskcard->threshold_flight_hour . ' FH / ';
                    }
                    else {
                        $threshold_interval .= '- FH / ';
                    }

                    if ($row->taskcard->threshold_flight_cycle) {
                        $threshold_interval .= $row->taskcard->threshold_flight_cycle . ' FC / ';
                    }
                    else {
                        $threshold_interval .= '- FC / ';
                    }

                    if ($row->taskcard->threshold_daily) {
                        $threshold_interval .= $row->taskcard->threshold_daily . ' ' . $row->taskcard->threshold_daily_unit . '(s)';
                    }
                    else {
                        $threshold_interval .= '- Day';
                    }

                    return $threshold_interval;
                })
                ->addColumn('repeat_interval', function($row){
                    $repeat_interval = '';
                    if ($row->taskcard->repeat_flight_hour) {
                        $repeat_interval .= $row->taskcard->repeat_flight_hour . ' FH / ';
                    }
                    else {
                        $repeat_interval .= '- FH / ';
                    }

                    if ($row->taskcard->repeat_flight_cycle) {
                        $repeat_interval .= $row->taskcard->repeat_flight_cycle . ' FC / ';
                    }
                    else {
                        $repeat_interval .= '- FC / ';
                    }

                    if ($row->taskcard->repeat_daily) {
                        $repeat_interval .= $row->taskcard->repeat_daily . ' ' . $row->taskcard->repeat_daily_unit . '(s)';
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
                ->addColumn('action', function($row) {
                    $noAuthorize = true;
                    if(Auth::user()->can('update', MaintenanceProgram::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', MaintenanceProgram::class)) {
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
        }
    }

    public function store(Request $request)
    {
        $existRow = MaintenanceProgramDetail::where('maintenance_program_id', $request->maintenance_program_id)
                                            ->where('taskcard_id', $request->taskcard_id)
                                            ->exists();
        if($existRow == false) {
            DB::beginTransaction();
            MaintenanceProgramDetail::create([
                'uuid' =>  Str::uuid(),
    
                'code' => $request->code,
                'name' => $request->name,
                'description' => $request->description,
                'maintenance_program_id' => $request->maintenance_program_id,
                'taskcard_id' => $request->taskcard_id,
    
                'owned_by' => $request->user()->company_id,
                'status' => 1,
                'created_by' => $request->user()->id,
            ]);
            DB::commit();
            return response()->json(['success' => 'Task Card has been Added to Maintenance Program']);
        }
        else {
            return response()->json(['error' => "This Task Card Already Exist in this Maintenance Program"]);
        }
    }

    public function update(Request $request, MaintenanceProgramDetail $MaintenanceProgramDetail)
    {
        $currentRow = MaintenanceProgram::where('id', $MaintenanceProgramDetail->maintenance_program_id)->first();

        if ($currentRow->approvals()->count() == 0) {
            // $request->validate([
            //     'aircraft_type_id' => ['required', 'max:30'],
            // ]);
    
            // if ($request->status) {
            //     $status = 1;
            // } 
            // else {
            //     $status = 0;
            // }

            $detailRow = MaintenanceProgramDetail::where('id', $MaintenanceProgramDetail->id)
                                                ->first();    
            $detailRow
                ->update([
                    'description' => $request->description,

                    'status' => 1,
                    'updated_by' => Auth::user()->id,
            ]);
            return response()->json(['success' => 'Remark has been Updated']);
        }
        else {
            return response()->json(['error' => "This Maintenance Program and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
        
    }

    public function destroy(MaintenanceProgramDetail $MaintenanceProgramDetail)
    {
        $currentRow = MaintenanceProgramDetail::where('id', $MaintenanceProgramDetail->id)->first();
        $currentRow
            ->update([
                'deleted_by' => Auth::user()->id,
            ]);

        MaintenanceProgramDetail::destroy($MaintenanceProgramDetail->id);
        return response()->json(['success' => "Task Card's Maintenance Program Data has been Deleted"]);
    }

    // public function select2(Request $request)
    // {
    //     $search = $request->q;

    //     $query = MaintenanceProgram::with('aircraft_type')
    //                 // ->whereHas('approvals')
    //                 ->where('status', 1);

    //     if($search != ''){
    //         $query = $query->where('name', 'like', '%' .$search. '%');
    //     }
    //     $MaintenancePrograms = $query->get();

    //     $response = [];
    //     foreach($MaintenancePrograms as $MaintenanceProgram){
    //         $response['results'][] = [
    //             "id" => $MaintenanceProgram->id,
    //             "text" => $MaintenanceProgram->name
    //         ];
    //     }
    //     return response()->json($response);
    // }
}
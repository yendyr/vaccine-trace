<?php

namespace Modules\PPC\Http\Controllers;

use Modules\PPC\Entities\TaskcardDetailInstruction;
use Modules\PPC\Entities\TaskcardDetailInstructionSkill;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TaskcardDetailInstructionController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(TaskcardDetailInstruction::class);
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'taskcard_id' => ['required'],
            'instruction_code' => ['required'],
            'manhours_estimation' => ['required'],
            'performance_factor' => ['required'],
            'engineering_level_id' => ['required'],
            'manpower_quantity' => ['required'],
            'task_release_level_id' => ['required'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }
        
        DB::beginTransaction();
        $TaskcardDetailInstruction = TaskcardDetailInstruction::create([
            'taskcard_id' => $request->taskcard_id,
            'uuid' => Str::uuid(),
            'sequence' => $request->sequence,
            'taskcard_workarea_id' => $request->taskcard_workarea_id,
            'instruction_code' => $request->instruction_code,
            'parent_id' => $request->parent_id,
            'manhours_estimation' => $request->manhours_estimation,
            'performance_factor' => $request->performance_factor,
            'engineering_level_id' => $request->engineering_level_id,
            'manpower_quantity' => $request->manpower_quantity,
            'task_release_level_id' => $request->task_release_level_id,
            'instruction' => $request->instruction,

            'owned_by' => $request->user()->company_id,
            'status' => 1,
            'created_by' => $request->user()->id,
        ]);

        if ($request->skill_id) {
            foreach ($request->skill_id as $skill_id) {
                $TaskcardDetailInstruction->skill_details()
                    ->save(new TaskcardDetailInstructionSkill([
                        'uuid' => Str::uuid(),
                        'skill_id' => $skill_id,
                        'owned_by' => $request->user()->company_id,
                        'status' => 1,
                        'created_by' => $request->user()->id,
                ]));
            }
        }

        DB::commit();
        return response()->json(['success' => 'Instruction has been Added']);
    
    }

    public function show(TaskcardDetailInstruction $TaskcardDetailInstruction)
    {
        $TaskcardDetailInstruction = TaskcardDetailInstruction::where('id', $TaskcardDetailInstruction->id)
                            ->with('instruction_group:id,instruction_code')
                            ->with('engineering_level:id,name')
                            ->with('taskcard_workarea:id,name')
                            ->with('task_release_level:id,name')
                            ->with('skills:id,name')
                            ->first();
        return response()->json($TaskcardDetailInstruction);
    }

    public function update(Request $request, TaskcardDetailInstruction $TaskcardDetailInstruction)
    {
        $request->validate([
            'taskcard_id' => ['required'],
            'instruction_code' => ['required'],
            'manhours_estimation' => ['required'],
            'performance_factor' => ['required'],
            'engineering_level_id' => ['required'],
            'manpower_quantity' => ['required'],
            'task_release_level_id' => ['required'],
        ]);

        $currentRow = TaskcardDetailInstruction::where('id', $TaskcardDetailInstruction->id)->first();

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        if (Self::isValidParent($currentRow, $request->parent_id)) {
            if ($request->parent_id == $currentRow->id) {
                $parent_id = null;
            }
            else {
                $parent_id = $request->parent_id;
            }
        }
        else {
            return response()->json(['error' => "The Choosen Parent is Already in Child of this Item"]);
        }

        DB::beginTransaction();
        $currentRow->update([
            'sequence' => $request->sequence,
            'taskcard_workarea_id' => $request->taskcard_workarea_id,
            'instruction_code' => $request->instruction_code,
            'parent_id' => $parent_id,
            'manhours_estimation' => $request->manhours_estimation,
            'performance_factor' => $request->performance_factor,
            'engineering_level_id' => $request->engineering_level_id,
            'manpower_quantity' => $request->manpower_quantity,
            'task_release_level_id' => $request->task_release_level_id,
            'instruction' => $request->instruction,

            'status' => 1,
            'updated_by' => Auth::user()->id,
        ]);  
        
        if ($request->skill_id) {
            $currentRow->skill_details()->forceDelete();

            foreach ($request->skill_id as $skill_id) {
                $currentRow->skill_details()
                    ->save(new TaskcardDetailInstructionSkill([
                        'uuid' => Str::uuid(),
                        'skill_id' => $skill_id,
                        'owned_by' => $request->user()->company_id,
                        'status' => 1,
                        'created_by' => $request->user()->id,
                ]));
            }
        }
        DB::commit();

        return response()->json(['success' => 'Instrcution has been Updated']);
    }

    public static function isValidParent($currentRow, $parent_id)
    {
        $isValid = true;
        foreach($currentRow->all_childs as $childRow) {
            if ($parent_id == $childRow->id) {
                $isValid = false;
                return $isValid;
                break;
            }
            else if (sizeof($childRow->all_childs) > 0) {
                Self::isValidParent($childRow, $parent_id);
            }
        }
        return $isValid;
    }

    public function tree(Request $request)
    {
        $taskcard_id = $request->taskcard_id;
        
        $datas = TaskcardDetailInstruction::where('taskcard_id', $taskcard_id)
                                ->with(['instruction_group:id,parent_id,instruction_code'])
                                ->where('taskcard_detail_instructions.status', 1)
                                // ->orderBy('created_at','asc')
                                ->get();

        $response = [];
        foreach($datas as $data) {
            if ($data->parent_id) {
                $parent = $data->parent_id;
            }
            else {
                $parent = '#';
            }

            $response[] = [
                "id" => $data->id,
                "parent" => $parent,
                "text" => 'Instruction Code: <strong>' . $data->instruction_code . '</strong>'
            ];
        }
        return response()->json($response);
    }

    public function destroy(TaskcardDetailInstruction $TaskcardDetailInstruction)
    {
        DB::beginTransaction();
        $currentDetailInstruction = TaskcardDetailInstruction::where('id', $TaskcardDetailInstruction->id)->first();
        $currentDetailInstruction
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        TaskcardDetailInstruction::destroy($TaskcardDetailInstruction->id);
        DB::commit();

        return response()->json(['success' => 'Instruction has been Deleted']);
    }

    public function select2Parent(Request $request)
    {
        $search = $request->term;
        $taskcard_id = $request->taskcard_id;

        $query = TaskcardDetailInstruction::orderby('instruction_code','asc')
                    ->select('id','instruction_code')
                    ->where('taskcard_id', $taskcard_id)
                    ->where('status', 1);

        if($search != ''){
            $query = $query->where('instruction_code', 'like', '%' .$search. '%');
        }
        $TaskcardDetailInstructions = $query->get();

        $response = [];
        foreach($TaskcardDetailInstructions as $TaskcardDetailInstruction){
            $response['results'][] = [
                "id" => $TaskcardDetailInstruction->id,
                "text" => $TaskcardDetailInstruction->instruction_code
            ];
        }

        return response()->json($response);
    }

    // public function select2Child(Request $request)
    // {
    //     $search = $request->q;

    //     $selectHaveParent = TaskcardGroup::orderby('name','asc')
    //                         ->select('parent_id')
    //                         ->where('parent_id', '<>', null)
    //                         ->where('status', 1);

    //     $query = TaskcardGroup::orderby('name','asc')
    //                 ->select('code','id','name')
    //                 ->whereNotIn('id', $selectHaveParent)
    //                 ->where('status', 1);

    //     if($search != ''){
    //         $query = $query->where('name', 'like', '%' .$search. '%');
    //     }
    //     $TaskcardGroups = $query->get();

    //     $response = [];
    //     foreach($TaskcardGroups as $TaskcardGroup){
    //         $response['results'][] = [
    //             "id" => $TaskcardGroup->id,
    //             "text" => $TaskcardGroup->code . ' | ' . $TaskcardGroup->name
    //         ];
    //     }

    //     return response()->json($response);
    // }
}
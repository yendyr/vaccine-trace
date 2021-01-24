<?php

namespace Modules\PPC\Http\Controllers;

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

class TaskcardDetailInstructionController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(TaskcardDetailInstruction::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'taskcard_id' => ['required'],
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
                            ->with('engineering_level:id,name')
                            ->with('taskcard_workarea:id,name')
                            ->with('task_release_level:id,name')
                            ->with('skills:id,name')
                            ->first();
        return response()->json($TaskcardDetailInstruction);
    }

    public function edit(TaskcardDetailInstruction $TaskcardDetailInstruction)
    {
        
    }

    public function update(Request $request, TaskcardDetailInstruction $TaskcardDetailInstruction)
    {
        $request->validate([
            'taskcard_id' => ['required'],
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
        $currentRow = TaskcardDetailInstruction::where('id', $TaskcardDetailInstruction->id)->first();
        $currentRow->update([
            'sequence' => $request->sequence,
            'taskcard_workarea_id' => $request->taskcard_workarea_id,
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
            $currentRow->skill_details()->delete();

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

    public function destroy(TaskcardDetailInstruction $TaskcardDetailInstruction)
    {
        DB::beginTransaction();
        $currentDetailInstruction = TaskcardDetailInstruction::where('id', $TaskcardDetailInstruction->id)->first();
        $currentDetailInstruction
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);
                    
        // $currentDetailInstructionSkill = TaskcardDetailInstructionSkill::where('taskcard_detail_instruction_id', $TaskcardDetailInstruction->id);
        // $currentDetailInstructionSkill
        //         ->update([
        //             'deleted_by' => Auth::user()->id,
        //         ]);

        // $currentDetailInstruction->skill_details()->delete();

        TaskcardDetailInstruction::destroy($TaskcardDetailInstruction->id);
        DB::commit();

        return response()->json(['success' => 'Instruction has been Deleted']);
    }

}
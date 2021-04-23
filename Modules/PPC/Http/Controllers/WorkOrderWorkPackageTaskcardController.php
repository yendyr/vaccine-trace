<?php

namespace Modules\PPC\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\PPC\Entities\WorkOrder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Modules\PPC\Entities\TaskcardGroup;
use Modules\PPC\Entities\WorkOrderWorkPackageTaskcard;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Modules\PPC\Entities\TaskcardDetailInstruction;
use Modules\PPC\Entities\TaskcardDetailInstructionSkill;
use Modules\PPC\Entities\WorkOrderWorkPackage;

class WorkOrderWorkPackageTaskcardController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(WorkOrder::class);
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @param WorkOrder $work_order
     * @param WorkOrderWorkPackage $work_package
     * @param WorkOrderWorkPackageTaskcard $taskcard
     * @return Renderable
     */
    public function index(Request $request, WorkOrder $work_order, WorkOrderWorkPackage $work_package)
    {
        if ($request->ajax()) {
            if( $work_order && $work_package ) {
                $data = WorkOrderWorkPackageTaskcard::query()
                                                ->where('work_order_id', $work_order->id)
                                                ->where('work_package_id', $work_package->id)
                                                ->with(['taskcard',
                                                        'taskcard.taskcard_type',
                                                        'taskcard.tags:id,code,name',
                                                        'work_order',
                                                        'work_package',
                                                    ]);
                return Datatables::of($data)
                ->addColumn('group_structure', function($row) {
                    if ($row->taskcard->taskcard_group_id) {
                        $currentRow = TaskcardGroup::where('id', $row->taskcard->taskcard_group_id)
                                                    ->withTrashed()
                                                    ->first();
                        $group_structure = '';

                        while (true) {
                            if ($currentRow) {
                                $group_structure = $currentRow->name . ' -> ' . $group_structure;
                                $currentRow = TaskcardGroup::where('id', $currentRow->parent_id)
                                                            ->withTrashed()
                                                            ->first();
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
                    return $row->taskcard->instruction_details()->count();
                })
                ->addColumn('manhours_total', function($row){
                    return number_format($row->taskcard->instruction_details()->sum('manhours_estimation'), 2, '.', '');
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
                    if(Auth::user()->can('update', WorkOrder::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', WorkOrder::class)) {
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
            }else{
                return DataTables::of([])
                ->make();
            }

        }
    }

    /**
     * Show the form for creating a new resource.
     * @param WorkOrder $work_order
     * @param WorkOrderWorkPackage $work_package
     * @param WorkOrderWorkPackageTaskcard $taskcard
     * @return Renderable
     */
    public function create(Request $request, WorkOrder $work_order, WorkOrderWorkPackage $work_package)
    {
        return view('ppc::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request, WorkOrder $work_order, WorkOrderWorkPackage $work_package)
    {
        $existRow = WorkOrderWorkPackageTaskcard::query()
                                            ->where('work_order_id', $work_order->id)
                                            ->where('work_package_id', $work_package->id)
                                            ->where('taskcard_id', $request->taskcard_id)
                                            ->exists();
        if($existRow == false) {
            DB::beginTransaction();
            $result = WorkOrderWorkPackageTaskcard::create([
                'uuid' =>  Str::uuid(),
    
                'code' => $request->code ?? null,
                'name' => $request->name ?? null,
                'description' => $request->description,
                'work_order_id' => $work_order->id,
                'work_package_id' => $work_package->id,
                'taskcard_id' => $request->taskcard_id,
    
                'owned_by' => $request->user()->company_id,
                'status' => 1,
                'created_by' => $request->user()->id,
            ]);

            if( !get_class($result) ) {
                $flag = false;
            }

            if($flag) {
                DB::commit();

                return response()->json(['success' => 'Task Card has been added to Maintenance Program']);
            }else{
                DB::commit();

                return response()->json(['success' => 'Failed to add task card to Maintenance Program']);
            }
        }
        else {
            return response()->json(['error' => "This Task Card Already Exist in this Maintenance Program"]);
        }
    }

    /**
     * Show the specified resource.
     * @param WorkOrder $work_order
     * @param WorkOrderWorkPackage $work_package
     * @param WorkOrderWorkPackageTaskcard $taskcard
     * @return Renderable
     */
    public function show(WorkOrder $work_order, WorkOrderWorkPackage $work_package, WorkOrderWorkPackageTaskcard $taskcard)
    {
        return view('ppc::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param WorkOrder $work_order
     * @param WorkOrderWorkPackage $work_package
     * @param WorkOrderWorkPackageTaskcard $taskcard
     * @return Renderable
     */
    public function edit(WorkOrder $work_order, WorkOrderWorkPackage $work_package, WorkOrderWorkPackageTaskcard $taskcard)
    {
        return view('ppc::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param WorkOrder $work_order
     * @param WorkOrderWorkPackage $work_package
     * @param WorkOrderWorkPackageTaskcard $taskcard
     * @return Renderable
     */
    public function update(Request $request, WorkOrder $work_order, WorkOrderWorkPackage $work_package, WorkOrderWorkPackageTaskcard $taskcard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param WorkOrder $work_order
     * @param WorkOrderWorkPackage $work_package
     * @param WorkOrderWorkPackageTaskcard $taskcard
     * @return Renderable
     */
    public function destroy(WorkOrder $work_order, WorkOrderWorkPackage $work_package, WorkOrderWorkPackageTaskcard $taskcard)
    {
        DB::beginTransaction();
        $flag = true;

        $updateRes = $taskcard->update([
                'deleted_by' => Auth::user()->id,
            ]);

        if ( !$updateRes ) {
            $flag = false;
        }

        $deleteRes = WorkOrderWorkPackageTaskcard::destroy('id', $taskcard->id);

        if( !$deleteRes ) {
            $flag = false;
        }

        if( $flag ) {
            DB::commit();

            return response()->json(['success' => "Task Card's Maintenance Program Data has been Deleted"]);
        }else{
            DB::rollBack();

            return response()->json(['error' => "Failed to delete Task Card's Maintenance Program Data"]);
        }
    }
}

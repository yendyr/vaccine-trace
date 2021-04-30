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
use Modules\PPC\Entities\Taskcard;
use Modules\PPC\Entities\TaskcardDetailInstruction;
use Modules\PPC\Entities\TaskcardDetailInstructionSkill;
use Modules\PPC\Entities\WorkOrderWorkPackage;
use Modules\PPC\Entities\WOWPTaskcardItem;

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
            if ($work_order && $work_package) {
                $data = WorkOrderWorkPackageTaskcard::query()
                    ->where('work_order_id', $work_order->id)
                    ->where('work_package_id', $work_package->id)
                    ->with([
                        'taskcard',
                        'taskcard.taskcard_type',
                        'taskcard.tags:id,code,name',
                        'work_package',
                    ]);
                return Datatables::of($data)
                    ->addColumn('group_structure', function ($row) {
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
                                } else {
                                    break;
                                }
                            }
                            $group_structure = Str::beforeLast($group_structure, '->');
                            return $group_structure;
                        } else {
                            return '-';
                        }
                    })
                    ->addColumn('status', function ($row) {
                        if ($row->status == 1) {
                            return '<label class="label label-success">Active</label>';
                        } else {
                            return '<label class="label label-danger">Inactive</label>';
                        }
                    })
                    ->addColumn('tag', function ($row) {
                        $tag_name = null;
                        foreach ($row->taskcard->tags as $tag) {
                            $tag_name .= $tag->name . ', ';
                        }

                        $tag_name = Str::beforeLast($tag_name, ',');
                        return $tag_name;
                    })
                    ->addColumn('instruction_count', function ($row) {
                        return $row->taskcard->instruction_details()->count();
                    })
                    ->addColumn('manhours_total', function ($row) {
                        return number_format($row->taskcard->instruction_details()->sum('manhours_estimation'), 2, '.', '');
                    })
                    ->addColumn('skills', function ($row) {
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
                    ->addColumn('threshold_interval', function ($row) {
                        $threshold_interval = '';
                        if ($row->taskcard->threshold_flight_hour) {
                            $threshold_interval .= $row->taskcard->threshold_flight_hour . ' FH / ';
                        } else {
                            $threshold_interval .= '- FH / ';
                        }

                        if ($row->taskcard->threshold_flight_cycle) {
                            $threshold_interval .= $row->taskcard->threshold_flight_cycle . ' FC / ';
                        } else {
                            $threshold_interval .= '- FC / ';
                        }

                        if ($row->taskcard->threshold_daily) {
                            $threshold_interval .= $row->taskcard->threshold_daily . ' ' . $row->taskcard->threshold_daily_unit . '(s)';
                        } else {
                            $threshold_interval .= '- Day';
                        }

                        return $threshold_interval;
                    })
                    ->addColumn('repeat_interval', function ($row) {
                        $repeat_interval = '';
                        if ($row->taskcard->repeat_flight_hour) {
                            $repeat_interval .= $row->taskcard->repeat_flight_hour . ' FH / ';
                        } else {
                            $repeat_interval .= '- FH / ';
                        }

                        if ($row->taskcard->repeat_flight_cycle) {
                            $repeat_interval .= $row->taskcard->repeat_flight_cycle . ' FC / ';
                        } else {
                            $repeat_interval .= '- FC / ';
                        }

                        if ($row->taskcard->repeat_daily) {
                            $repeat_interval .= $row->taskcard->repeat_daily . ' ' . $row->taskcard->repeat_daily_unit . '(s)';
                        } else {
                            $repeat_interval .= '- Day';
                        }

                        return $repeat_interval;
                    })
                    ->addColumn('creator_name', function ($row) {
                        return $row->creator->name ?? '-';
                    })
                    ->addColumn('updater_name', function ($row) {
                        return $row->updater->name ?? '-';
                    })
                    ->addColumn('action', function ($row) use ($request) {
                        $noAuthorize = true;
                        if ( $request->user()->can('update', $row) ) {
                            $updateable = 'button';
                            $updateValue = $row->id;
                            $noAuthorize = false;
                        }
                        if ( $request->user()->can('delete', $row) ) {
                            $deleteable = true;
                            $deleteId = $row->id;
                            $noAuthorize = false;
                        }

                        if ($noAuthorize == false) {
                            return view('components.action-button', compact(['updateable', 'updateValue', 'deleteable', 'deleteId']));
                        } else {
                            return '<p class="text-muted font-italic">Not Authorized</p>';
                        }
                    })
                    ->escapeColumns([])
                    ->make(true);
            } else {
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
        $is_authorized = $request->user()->can('update', $work_order);
        $is_use_all_taskcard = Str::contains($request->fullUrl(), 'use-all-taskcard');

        if( !$is_authorized ) {

            if( $is_use_all_taskcard ){
                return ['error' => 'Action is not authorized', 'flag' => false];
            }else{
                return response()->json(['error' => 'Action is not authorized']);
            }

        }

        if( !$is_use_all_taskcard ) {
            DB::beginTransaction();
        }

        $existRow = WorkOrderWorkPackageTaskcard::query()
            ->where('work_order_id', $work_order->id)
            ->where('taskcard_id', $request->taskcard_id)
            ->exists();

        if ($existRow == false) {
            $flag = true;
            $taskcard = Taskcard::find($request->taskcard_id);

            if (!$taskcard) {
                $flag = false;

                DB::rollBack();

                if( $is_use_all_taskcard ){
                    return ['error' => 'Failed to find task card', 'flag' => false];
                }else{
                    return response()->json(['error' => 'Failed to find task card']);
                }
            }

            $workpackage_taskcard = WorkOrderWorkPackageTaskcard::create([
                'uuid' =>  Str::uuid(),

                'work_order_id' => $work_order->id,
                'work_package_id' => $work_package->id,
                'taskcard_id' => $request->taskcard_id,
                'description' => $request->description,

                'taskcard_json' => json_encode($taskcard),
                'taskcard_group_json' => json_encode($taskcard->taskcard_group),
                'taskcard_type_json' => json_encode($taskcard->taskcard_type),
                'taskcard_workarea_json' => json_encode($taskcard->taskcard_workarea),
                'aircraft_types_json' => json_encode($taskcard->aircraft_types),
                'aircraft_type_details_json' => json_encode($taskcard->aircraft_type_details),
                'affected_items_json' => json_encode($taskcard->affected_items),
                'affected_item_details_json' => json_encode($taskcard->affected_item_details),
                'tags_json' => json_encode($taskcard->tags),
                'tag_details_json' => json_encode($taskcard->tag_details),
                'accesses_json' => json_encode($taskcard->accesses),
                'access_details_json' => json_encode($taskcard->access_details),
                'zones_json' => json_encode($taskcard->zones),
                'zone_details_json' => json_encode($taskcard->zone_details),
                'document_libraries_json' => json_encode($taskcard->document_libraries),
                'document_library_details_json' => json_encode($taskcard->document_library_details),
                'affected_manuals_json' => json_encode($taskcard->affected_manuals),
                'affected_manual_details_json' => json_encode($taskcard->affected_manual_details),
                'instruction_details_json' => json_encode($taskcard->instruction_details()->with('skills')->get()),
                'items_json' => json_encode($taskcard->items),
                'item_details_json' => json_encode($taskcard->item_details),

                'owned_by' => $request->user()->company_id,
                'status' => 1,
                'created_by' => $request->user()->id,
            ]);


            if (!get_class($workpackage_taskcard)) {
                $flag = false;
            }

            $taskcard_total_manhours = $taskcard->instruction_details()->sum('manhours_estimation') ?? 0;
            $total_manhours = ($work_package->total_manhours) ? $work_package->total_manhours + $taskcard_total_manhours : 0 + $taskcard_total_manhours;
            $result = $work_package->update(['total_manhours' => $total_manhours]);

            if (!$result) {
                $flag = false;
            }

            if (!$taskcard->item_details->isEmpty()) {
                foreach ($taskcard->item_details as $item_detail_row) {
                    $item_detail = WOWPTaskcardItem::create([
                        'uuid' =>  Str::uuid(),

                        'work_order_id' => $work_order->id,
                        'work_package_id' => $work_package->id,
                        'taskcard_id' => $workpackage_taskcard->id,
                        'item_id' => $item_detail_row->item_id,
                        'quantity' => $item_detail_row->quantity,
                        'unit_id' => $item_detail_row->unit_id,
                        'description' => $item_detail_row->description,

                        'owned_by' => $request->user()->company_id,
                        'status' => 1,
                        'created_by' => $request->user()->id,
                    ]);

                    if (!get_class($item_detail)) {
                        $flag = false;
                    }
                }
            }

            if ($flag) {
                
                if( $is_use_all_taskcard ){
                    return ['success' => 'Task Card has been added to Maintenance Program', 'total_manhours' => number_format($total_manhours, 2), 'total_manhours_with_performance_factor' => number_format($total_manhours * $work_package->performance_factor, 2), 'flag' => $flag];
                }else{
                    DB::commit();

                    return response()->json(['success' => 'Task Card has been added to Maintenance Program', 'total_manhours' => number_format($total_manhours, 2), 'total_manhours_with_performance_factor' => number_format($total_manhours * $work_package->performance_factor, 2), 'flag' => $flag]);
                }

            } else {
                
                if( $is_use_all_taskcard ){
                    return ['error' => 'Failed to add task card to Maintenance Program', 'flag' => $flag];
                }else{
                    DB::rollBack();
                    
                    return response()->json(['error' => 'Failed to add task card to Maintenance Program', 'flag' => $flag]);
                }

            }
        } else {

            if( $is_use_all_taskcard ){
                return ['error' => "This Task Card Already Exist in this Maintenance Program", 'flag' => false];
            }else{
                return response()->json(['error' => "This Task Card Already Exist in this Maintenance Program"]);
            }

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
    public function destroy(Request $request, WorkOrder $work_order, WorkOrderWorkPackage $work_package, WorkOrderWorkPackageTaskcard $taskcard)
    {
        $is_authorized = $request->user()->can('delete', $work_order->id);

        if( !$is_authorized ) {
            return response()->json(['error' => 'Work Order already approved']);
        }

        DB::beginTransaction();
        $flag = true;

        $updateRes = $taskcard->update([
            'deleted_by' => Auth::user()->id,
        ]);

        if (!$updateRes) {
            $flag = false;
        }

        $deleteRes = WorkOrderWorkPackageTaskcard::destroy('id', $taskcard->id);

        if (!$deleteRes) {
            $flag = false;
        }

        $taskcard = Taskcard::find($taskcard->id);
        $taskcard_total_manhours = $taskcard->instruction_details()->sum('manhours_estimation') ?? 0;
        $total_manhours = ($work_package->total_manhours) ? $work_package->total_manhours - $taskcard_total_manhours : 0 - $taskcard_total_manhours;
        $result = $work_package->update(['total_manhours' => $total_manhours]);

        if (!$result) {
            $flag = false;
        }

        if ($flag) {
            DB::commit();

            return response()->json(['success' => "Task Card's Maintenance Program Data has been Deleted", 'total_manhours' => number_format($total_manhours, 2), 'total_manhours_with_performance_factor' => number_format($total_manhours * $work_package->performance_factor, 2)]);
        } else {
            DB::rollBack();

            return response()->json(['error' => "Failed to delete Task Card's Maintenance Program Data"]);
        }
    }

}

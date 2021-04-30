<?php

namespace Modules\PPC\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\PPC\Entities\WorkOrder;
use Modules\PPC\Entities\WorkOrderWorkPackage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Modules\PPC\Entities\Taskcard;

class WorkOrderWorkPackageController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(WorkOrder::class);
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(WorkOrder $work_order, Request $request)
    {
        if ($request->ajax()) {
            $work_orders = WorkOrderWorkPackage::where('work_order_id', $work_order->id)->with('work_order:id')->latest();

            return Datatables::of($work_orders)
                ->addColumn('number', function ($row) use ($request) {
                    if (!$request->aircraft_type_id) {
                        $noAuthorize = true;
                        if ($request->user()->can('view', WorkOrder::class)) {
                            $showText = $row->code;
                            $noAuthorize = false;
                            $route = route('ppc.work-order.work-package.show', ['work_order' => $row->work_order->id, 'work_package' => $row->id]);
                        }

                        if ($request->user()->can('update', $row->work_order)) {
                            $showText = $row->code;
                            $noAuthorize = false;
                            $route = route('ppc.work-order.work-package.edit', ['work_order' => $row->work_order->id, 'work_package' => $row->id]);
                        }

                        if ($noAuthorize == false) {
                            return  '<a href="' . $route . '">' . $showText . '</a>';
                        } else {
                            return '<p class="text-muted font-italic">Not Authorized</p>';
                        }
                    }
                })
                ->addColumn('action', function ($row) use ($request) {
                    if (!$request->aircraft_type_id) {
                        $noAuthorize = true;

                        if ($request->user()->can('update', $row->work_order)) {
                            $updateable = 'button';
                            $updateValue = $row->id;
                            $noAuthorize = false;
                        }

                        if ($request->user()->can('delete', $row->work_order)) {
                            $deleteable = true;
                            $deleteId = $row->id;
                            $noAuthorize = false;
                        }

                        if ($noAuthorize == false) {
                            return view('components.action-button', compact(['updateable', 'updateValue', 'deleteable', 'deleteId']));
                        } else {
                            return '<p class="text-muted font-italic">Not Authorized</p>';
                        }
                    }
                })
                ->escapeColumns([])
                ->make();
        }

        return response()->json('index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(WorkOrder $work_order)
    {
        return 'create';
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request, WorkOrder $work_order)
    {
        $is_authorized = $request->user()->can('update', $work_order);

        if (!$is_authorized) {
            return response()->json(['error' => 'Work Order already approved']);
        }

        $request->validate([
            'code' => ['required', 'max:30'],
            'name' => ['required', 'max:30'],
            'performance_factor' => ['required', 'numeric'],
            'work_order_id' => ['required', 'exists:work_orders,id'],
        ]);

        DB::beginTransaction();

        $flag = true;

        $request->merge([
            'uuid' =>  Str::uuid(),
            'owned_by' => $request->user()->company_id,
            'status' => 1,
            'created_by' => $request->user()->id,
        ]);

        $work_package = WorkOrderWorkPackage::create($request->all());

        if (!$work_package->id) {
            $flag = false;
        }

        if ($flag) {
            DB::commit();

            return response()->json(['success' => 'Work Package has been created']);
        } else {
            DB::rollBack();

            return response()->json(['error' => "Work Package failed to create"]);
        }
    }

    /**
     * Show the specified resource.
     * @param WorkOrderWorkPackage $work_order_work_package
     * @return Renderable
     */
    public function show(WorkOrder $work_order, WorkOrderWorkPackage $work_package)
    {
        return view('ppc::pages.work-order.work-package.show', [
            'work_order' => $work_order,
            'work_package' => $work_package
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param WorkOrderWorkPackage $work_order_work_package
     * @return Renderable
     */
    public function edit(Request $request, WorkOrder $work_order, WorkOrderWorkPackage $work_package)
    {
        $skills = $taskcard_counts = [];

        if( $work_package->taskcards()->count() > 0 ) {
            foreach ($work_package->taskcards as $taskcardRow) {

                $taskcard_group = json_decode($taskcardRow->taskcard_group_json);

                if( !empty($taskcard_group) ) {
                    if( empty($taskcard_counts[$taskcard_group->code]) ){
                        $taskcard_counts[$taskcard_group->code]['name'] = $taskcard_group->name;
                        $taskcard_counts[$taskcard_group->code]['count'] = 1;
                    }else{
                        $taskcard_counts[$taskcard_group->code]['count']++;
                    }
                }

                $instruction_details = json_decode($taskcardRow->instruction_details_json);

    
                if( !empty($instruction_details) ) {

                    foreach( $instruction_details as $instruction_detail_row ) {

                        if( sizeof($instruction_detail_row->skills) > 0 ) {

                            foreach ($instruction_detail_row->skills as $skillRow) {

                                if( isset($skills[$skillRow->name]) ) {
                                    $skills[$skillRow->name]++;
                                }else{
                                    $skills[$skillRow->name] = 1;
                                }

                            }
                            
                        }

                    }

                } 
                
            }
        }
        
        return view('ppc::pages.work-order.work-package.index', [
            'skills' => $skills,
            'work_order' => $work_order,
            'work_package' => $work_package,
            'taskcard_counts' => $taskcard_counts
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param WorkOrderWorkPackage $work_order_work_package
     * @return Renderable
     */
    public function update(Request $request, WorkOrder $work_order, WorkOrderWorkPackage $work_package)
    {
        $request->validate([
            'code' => ['required', 'max:30'],
            'name' => ['required', 'max:30'],
            'performance_factor' => ['required', 'numeric'],
            'work_order_id' => ['required', 'exists:work_orders,id'],
        ]);

        $is_authorized = $request->user()->can('update', $work_order);

        if (!$is_authorized) {
            return response()->json(['error' => 'Work Order already approved']);
        }

        DB::beginTransaction();

        $flag = true;
        $result = $work_package->update($request->all());

        if (!$result) {
            $flag = false;
        }

        if ($flag) {
            DB::commit();

            return response()->json(['success' => 'Work Package has been updated']);
        } else {
            DB::rollBack();

            return response()->json(['error' => "Work Package failed to update"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param WorkOrderWorkPackage $work_order_work_package
     * @return Renderable
     */
    public function destroy(Request $request, WorkOrder $work_order, WorkOrderWorkPackage $work_package)
    {
        $is_authorized = $request->user()->can('delete', $work_order);

        if (!$is_authorized) {
            return response()->json(['error' => 'Work Order already approved']);
        }

        DB::beginTransaction();

        $flag = true;

        $result = $work_package->delete();

        if (!$result) {
            $flag = false;
        }

        if ($flag) {
            DB::commit();

            return response()->json(['success' => 'Work Package has been deleted']);
        } else {
            DB::rollBack();

            return response()->json(['error' => "Work Package failed to delete"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param WorkOrder $work_order
     * @param WorkOrderWorkPackage $work_package
     * @return Renderable
     */
    public function useAll(Request $request, WorkOrder $work_order, WorkOrderWorkPackage $work_package)
    {
        DB::beginTransaction();
        $flag = true;
        $existed_taskcard = $work_order->taskcards()->pluck('taskcard_id');
        $objWorkOrderWorkPackageTaskcardController = new WorkOrderWorkPackageTaskcardController();
        $taskcards_query = Taskcard::whereHas(
            'aircraft_types',
            function ($aircraft_types) use ($work_order) {
                $aircraft_types->where('aircraft_types.id', $work_order->aircraft->aircraft_type_id);
            }
        )
            ->whereNotIn('id', $existed_taskcard);

        if ($taskcards_query->count() !== 0) {

            $taskcards = $taskcards_query->pluck('id');

            foreach ($taskcards as $taskcard_id_row) {
                $request->merge([
                    'taskcard_id' => $taskcard_id_row
                ]);

                $result = $objWorkOrderWorkPackageTaskcardController->store($request, $work_order, $work_package);

                $flag = $result['flag'];
            }

            if ($flag) {
                DB::commit();

                return response()->json(['success' => 'All Task Card has been added to Maintenance Program', 'total_manhours' => number_format($result['total_manhours'], 2), 'total_manhours_with_performance_factor' => number_format($result['total_manhours'] * $work_package->performance_factor, 2), 'flag' => $flag]);
            } else {
                DB::rollBack();

                return response()->json(['error' => 'Failed to add all task card to Maintenance Program', 'flag' => $flag]);
            }
        }
    }

        /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function itemRequirements(WorkOrder $work_order, Request $request)
    {
        if ($request->ajax()) {

            $items = [];

            if( $work_order->taskcards()->count() > 0 ) {
                foreach ($work_order->taskcards as $taskcardRow) {
                    $taskcard_items = json_decode($taskcardRow->items_json);
                }
            }

            return Datatables::of($items)
                ->escapeColumns([])
                ->make();
        }

        abort(500);
    }
}

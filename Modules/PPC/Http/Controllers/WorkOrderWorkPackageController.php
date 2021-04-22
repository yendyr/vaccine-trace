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
            $work_orders = WorkOrderWorkPackage::where('work_order_id', $work_order->id)->latest();

            return Datatables::of($work_orders)
                ->addColumn('number', function ($row) use ($request) {
                    if (!$request->aircraft_type_id) {
                        $noAuthorize = true;
                        if ($request->user()->can('view', WorkOrder::class)) {
                            $showText = $row->code;
                            $noAuthorize = false;
                            $route = route('ppc.work-order.work-package.show', ['work_order' => $row->workOrder->id, 'work_package' => $row->id]);
                        }

                        if ($request->user()->can('update', WorkOrder::class)) {
                            $showText = $row->code;
                            $noAuthorize = false;
                            $route = route('ppc.work-order.work-package.edit', ['work_order' => $row->workOrder->id, 'work_package' => $row->id]);
                        }

                        if ($noAuthorize == false) {
                            return  '<a href="'. $route.'">'. $showText .'</a>';
                        } else {
                            return '<p class="text-muted font-italic">Not Authorized</p>';
                        }
                    } 
                })
                ->addColumn('action', function ($row) use ($request) {
                    if (!$request->aircraft_type_id) {
                        $noAuthorize = true;
                        if ($request->user()->can('update', WorkOrder::class)) {
                            $updateable = 'button';
                            $updateValue = $row->id;
                            $noAuthorize = false;
                        }
                        if ($request->user()->can('delete', WorkOrder::class)) {
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
    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'max:30'],
            'title' => ['required', 'max:30'],
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

        if( !$work_package->id ) {
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
    public function edit(WorkOrder $work_order, WorkOrderWorkPackage $work_package)
    {
        return view('ppc::pages.work-order.work-package.index', [
            'work_order' => $work_order,
            'work_package' => $work_package
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
            'title' => ['required', 'max:30'],
            'performance_factor' => ['required', 'numeric'],
            'work_order_id' => ['required', 'exists:work_orders,id'],
        ]);

        DB::beginTransaction();

        $flag = true;
        $result = $work_package->update($request->all());

        if( !$result ) {
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
    public function destroy(WorkOrder $work_order, WorkOrderWorkPackage $work_package)
    {
        DB::beginTransaction();

        $flag = true;

        $result = $work_package->delete();

        if( !$result ) {
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
}

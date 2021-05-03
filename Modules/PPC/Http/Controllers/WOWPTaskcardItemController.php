<?php

namespace Modules\PPC\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\PPC\Entities\Taskcard;
use Modules\PPC\Entities\WorkOrder;
use Modules\PPC\Entities\WorkOrderWorkPackage;
use Modules\PPC\Entities\WOWPTaskcardItem;
use Yajra\DataTables\Facades\DataTables;

class WOWPTaskcardItemController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(WorkOrder::class);
        $this->middleware('auth');
    }

    public function index(Request $request, WorkOrder $work_order, WorkOrderWorkPackage $work_package)
    {
        if ($request->ajax()) {
            $data = WOWPTaskcardItem::query()
                                        ->where('work_order_id', $work_order->id)
                                        ->where('work_package_id', $work_package->id)
                                        ->with([
                                            'item:id,code,name',
                                            'unit:id,name',
                                            'category:id,name',
                                        ]);
                                        
            return Datatables::of($data)  
                ->addColumn('creator_name', function($row){
                    return $row->creator->name ?? '-';
                })
                ->addColumn('updater_name', function($row){
                    return $row->updater->name ?? '-';
                })
                ->addColumn('action', function($row) use ($request) {
                    $noAuthorize = true;
                    if( $request->user()->can('update', Taskcard::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $editButtonClass = 'editButtonItem';
                        $noAuthorize = false;
                    }
                    if( $request->user()->can('delete', Taskcard::class)) {
                        $deleteable = true;
                        $deleteButtonClass = 'deleteButtonItem';
                        $deleteId = $row->id;
                        $noAuthorize = false;
                    }

                    if ($noAuthorize == false) {
                        return view('components.action-button', compact(['updateable', 'updateValue','editButtonClass','deleteable', 'deleteId', 'deleteButtonClass']));
                    }
                    else {
                        return '<p class="text-muted font-italic">Not Authorized</p>';
                    }
                    
                })
                ->escapeColumns([])
                ->make(true);
        }

        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request, WorkOrder $work_order, WorkOrderWorkPackage $work_package, Taskcard $taskcard)
    {
        return view('ppc::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request, WorkOrder $work_order, WorkOrderWorkPackage $work_package, Taskcard $taskcard, WOWPTaskcardItem $item)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Request $request, WorkOrder $work_order, WorkOrderWorkPackage $work_package, Taskcard $taskcard, WOWPTaskcardItem $item)
    {
        return view('ppc::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Request $request, WorkOrder $work_order, WorkOrderWorkPackage $work_package, Taskcard $taskcard, WOWPTaskcardItem $item)
    {
        return view('ppc::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, WorkOrder $work_order, WorkOrderWorkPackage $work_package, Taskcard $taskcard, WOWPTaskcardItem $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request, WorkOrder $work_order, WorkOrderWorkPackage $work_package, Taskcard $taskcard, WOWPTaskcardItem $item)
    {
        //
    }
}

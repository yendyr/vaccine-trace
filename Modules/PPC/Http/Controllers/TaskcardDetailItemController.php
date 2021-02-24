<?php

namespace Modules\PPC\Http\Controllers;

use Modules\PPC\Entities\Taskcard;
use Modules\PPC\Entities\TaskcardDetailItem;
use Modules\SupplyChain\Entities\Item;

use Illuminate\Support\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TaskcardDetailItemController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(TaskcardDetailItem::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TaskcardDetailItem::with([
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
                ->addColumn('action', function($row){
                    $noAuthorize = true;
                    if(Auth::user()->can('update', Taskcard::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $editButtonClass = 'editButtonItem';
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', Taskcard::class)) {
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
    }

    public function store(Request $request)
    {
        $request->validate([
            'taskcard_id' => ['required'],
            'item_id' => ['required'],
            'quantity' => ['required'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        $unit_id = Item::where('id',$request->item_id)->value('primary_unit_id');
        
        $TaskcardDetailItem = TaskcardDetailItem::create([
            'taskcard_id' => $request->taskcard_id,
            'uuid' => Str::uuid(),
            'taskcard_detail_instruction_id' => $request->taskcard_detail_instruction_id,
            'item_id' => $request->item_id,
            'quantity' => $request->quantity,
            'unit_id' => $unit_id,
            'description' => $request->description,

            'owned_by' => $request->user()->company_id,
            'status' => 1,
            'created_by' => $request->user()->id,
        ]);

        return response()->json(['success' => 'Item has been Added']);
    
    }

    public function show(TaskcardDetailItem $TaskcardDetailItem)
    {
        $TaskcardDetailItem = TaskcardDetailItem::where('id', $TaskcardDetailItem->id)
                                ->with('item:id,code,name')
                                ->first();

        return response()->json($TaskcardDetailItem);
    }

    public function update(Request $request, TaskcardDetailItem $TaskcardDetailItem)
    {
        $request->validate([
            'taskcard_id' => ['required'],
            'item_id' => ['required'],
            'quantity' => ['required'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        $unit_id = Item::where('id',$request->item_id)->value('primary_unit_id');
        
        $currentRow = TaskcardDetailItem::where('id', $TaskcardDetailItem->id)->first();
        $currentRow->update([
            'item_id' => $request->item_id,
            'quantity' => $request->quantity,
            'unit_id' => $unit_id,
            'description' => $request->description,

            'status' => 1,
            'updated_by' => $request->user()->id,
        ]);

        return response()->json(['success' => 'Item has been Updated']);
    
    }

    public function destroy(TaskcardDetailItem $TaskcardDetailItem)
    {
        $TaskcardDetailItem = TaskcardDetailItem::where('id', $TaskcardDetailItem->id)->first();
        $TaskcardDetailItem
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        TaskcardDetailItem::destroy($TaskcardDetailItem->id);

        return response()->json(['success' => 'Item has been Deleted']);
    }

}
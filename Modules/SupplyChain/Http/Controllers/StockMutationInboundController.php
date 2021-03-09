<?php

namespace Modules\SupplyChain\Http\Controllers;

use Modules\SupplyChain\Entities\StockMutation;
use Modules\SupplyChain\Entities\StockMutationApproval;
use Modules\SupplyChain\Entities\ItemStock;
use Modules\PPC\Entities\ItemStockInitialAging;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;

class StockMutationInboundController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(StockMutation::class, 'mutation_inbound');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = StockMutation::with(['destination','approvals'])
                                    ->get();

            return Datatables::of($data)
                ->addColumn('reference', function($row){
                    if ($row->transaction_reference_id) {
                        return $row->transaction_reference_id;
                    } 
                    else {
                        return "-";
                    }
                })
                ->addColumn('creator_name', function($row){
                    return $row->creator->name ?? '-';
                })
                ->addColumn('updater_name', function($row){
                    return $row->updater->name ?? '-';
                })
                ->addColumn('action', function($row){
                    $noAuthorize = true;
                    $approvable = false;
                    $approveId = null;

                    if ($row->approvals()->count() > 0) {
                        return '<p class="text-muted font-italic">Already Approved</p>';
                    }
                    else {
                        if(Auth::user()->can('update', StockMutation::class)) {
                            $updateable = 'button';
                            $updateValue = $row->id;
                            $noAuthorize = false;
                        }
                        if(Auth::user()->can('delete', StockMutation::class)) {
                            $deleteable = true;
                            $deleteId = $row->id;
                            $noAuthorize = false;
                        }
                        if(Auth::user()->can('approval', StockMutation::class)) {
                            $approvable = true;
                            $approveId = $row->id;
                            $noAuthorize = false;
                        }
                        
                        if ($noAuthorize == false) {
                            return view('components.action-button', compact(['updateable', 'updateValue','deleteable', 'deleteId', 'approvable', 'approveId']));
                        }
                        else {
                            return '<p class="text-muted font-italic">Not Authorized</p>';
                        }
                    }
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('supplychain::pages.mutation.inbound.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => ['required', 'max:30'],
            'warehouse_destination' => ['required', 'max:30'],
            'description' => ['required'],
        ]);

        $transaction_date = Carbon::parse($request->transaction_date);

        DB::beginTransaction();
        $StockMutation = StockMutation::create([
            'uuid' =>  Str::uuid(),

            'transaction_date' => $transaction_date,
            'warehouse_destination' => $request->warehouse_destination,
            'description' => $request->description,

            'status' => 1,
            'owned_by' => $request->user()->company_id,
            'created_by' => $request->user()->id,
        ]);

        $code = 'INBND-' . 
        $transaction_date->year . '-' .
        str_pad($StockMutation->id, 5, '0', STR_PAD_LEFT);

        $StockMutation->update([
            'code' => $code
        ]);
        DB::commit();
    
        return response()->json(['success' => 'Stock Mutation Inbound Data has been Saved',
                                    'id' => $StockMutation->id]);
    }

    public function show(StockMutation $MutationInbound)
    {
        return view('supplychain::pages.mutation.inbound.show', compact('MutationInbound'));
    }

    public function update(Request $request, StockMutation $MutationInbound)
    {
        $currentRow = StockMutation::where('id', $MutationInbound->id)->first();
        if ($currentRow->approvals()->count() == 0) {
            $request->validate([
                'transaction_date' => ['required', 'max:30'],
                'warehouse_destination' => ['required', 'max:30'],
                'description' => ['required'],
            ]);

            $transaction_date = Carbon::parse($request->transaction_date);
        
            $currentRow->update([
                'transaction_date' => $transaction_date,
                'warehouse_destination' => $request->warehouse_destination,
                'description' => $request->description,

                'updated_by' => Auth::user()->id,
            ]);
            
            return response()->json(['success' => 'Stock Mutation Inbound Data has been Updated',
                                        'id' => $MutationInbound->id]);
        }
        else {
            return response()->json(['error' => "This Stock Mutation Inbound and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function destroy(StockMutation $MutationInbound)
    {
        $currentRow = StockMutation::where('id', $MutationInbound->id)->first();
        $currentRow
            ->update([
                'deleted_by' => Auth::user()->id,
            ]);

        StockMutation::destroy($MutationInbound->id);
        return response()->json(['success' => 'Stock Mutation Inbound Data has been Deleted']);
    }

    public function approve(Request $request, StockMutation $MutationInbound)
    {
        $request->validate([
            'approval_notes' => ['required', 'max:30'],
        ]);

        DB::beginTransaction();
        StockMutationApproval::create([
            'uuid' =>  Str::uuid(),

            'stock_mutation_id' =>  $MutationInbound->id,
            'approval_notes' =>  $request->approval_notes,
    
            'owned_by' => $request->user()->company_id,
            'status' => 1,
            'created_by' => Auth::user()->id,
        ]);
        $MutationInbound->item_stocks()->forceDelete();
        foreach($MutationInbound->stock_mutation_details as $stock_mutation_detail) {
            $MutationInbound->item_stocks()
                ->save(new ItemStock([
                    'uuid' => Str::uuid(),

                    'item_id' => $stock_mutation_detail->item_id,
                    'quantity' => $stock_mutation_detail->quantity,
                    'serial_number' => $stock_mutation_detail->serial_number,
                    'alias_name' => $stock_mutation_detail->alias_name,
                    'highlight' => $stock_mutation_detail->highlight,
                    'description' => $stock_mutation_detail->description,
                    'parent_coding' => $stock_mutation_detail->parent_coding,
                    
                    'owned_by' => $request->user()->company_id,
                    'status' => 1,
                    'created_by' => $request->user()->id,
                ]));
        }

        DB::commit();

        return response()->json(['success' => 'Stock Mutation Inbound Data has been Approved']);
    }
}
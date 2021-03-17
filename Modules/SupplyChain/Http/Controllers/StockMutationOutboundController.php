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

class StockMutationOutboundController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(StockMutation::class, 'mutation_outbound');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = StockMutation::with(['origin','approvals']);

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
        return view('supplychain::pages.mutation.outbound.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => ['required', 'max:30'],
            'warehouse_origin' => ['required', 'max:30'],
            'description' => ['required'],
        ]);

        $transaction_date = Carbon::parse($request->transaction_date);

        DB::beginTransaction();
        $StockMutation = StockMutation::create([
            'uuid' =>  Str::uuid(),

            'transaction_date' => $transaction_date,
            'warehouse_origin' => $request->warehouse_origin,
            'description' => $request->description,

            'status' => 1,
            'owned_by' => $request->user()->company_id,
            'created_by' => $request->user()->id,
        ]);

        $code = 'OUTBD-' . 
        $transaction_date->year . '-' .
        str_pad($StockMutation->id, 5, '0', STR_PAD_LEFT);

        $StockMutation->update([
            'code' => $code
        ]);
        DB::commit();
    
        return response()->json(['success' => 'Stock Mutation Outbound Data has been Saved',
                                    'id' => $StockMutation->id]);
    }

    public function show(StockMutation $MutationOutbound)
    {
        return view('supplychain::pages.mutation.outbound.show', compact('MutationOutbound'));
    }

    public function update(Request $request, StockMutation $MutationOutbound)
    {
        $currentRow = StockMutation::where('id', $MutationOutbound->id)->first();
        if ($currentRow->approvals()->count() == 0) {
            $request->validate([
                'transaction_date' => ['required', 'max:30'],
                'warehouse_origin' => ['required', 'max:30'],
                'description' => ['required'],
            ]);

            $transaction_date = Carbon::parse($request->transaction_date);
        
            $currentRow->update([
                'transaction_date' => $transaction_date,
                'warehouse_origin' => $request->warehouse_origin,
                'description' => $request->description,

                'updated_by' => Auth::user()->id,
            ]);
            
            return response()->json(['success' => 'Stock Mutation Outbound Data has been Updated',
                                        'id' => $MutationOutbound->id]);
        }
        else {
            return response()->json(['error' => "This Stock Mutation Outbound and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function destroy(StockMutation $MutationOutbound)
    {
        $currentRow = StockMutation::where('id', $MutationOutbound->id)->first();
        $currentRow
            ->update([
                'deleted_by' => Auth::user()->id,
            ]);

        StockMutation::destroy($MutationOutbound->id);
        return response()->json(['success' => 'Stock Mutation Outbound Data has been Deleted']);
    }

    public function approve(Request $request, StockMutation $MutationOutbound)
    {
        $request->validate([
            'approval_notes' => ['required', 'max:30'],
        ]);

        DB::beginTransaction();
        StockMutationApproval::create([
            'uuid' =>  Str::uuid(),

            'stock_mutation_id' =>  $MutationOutbound->id,
            'approval_notes' =>  $request->approval_notes,
    
            'owned_by' => $request->user()->company_id,
            'status' => 1,
            'created_by' => Auth::user()->id,
        ]);

        foreach ($MutationOutbound->item_stocks as $item_stock) {
            $item_stock->item_stock_initial_aging()->forceDelete();
        }
        $MutationOutbound->item_stocks()->forceDelete();

        foreach($MutationOutbound->stock_mutation_details as $stock_mutation_detail) {
            $ItemStock = new ItemStock([
                'uuid' => Str::uuid(),

                'warehouse_id' => $MutationOutbound->warehouse_destination,
                'coding' => $stock_mutation_detail->coding,
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
            ]);

            $Item_Stock = $MutationOutbound->item_stocks()->save($ItemStock);

            $ItemStockInitialAging = new ItemStockInitialAging([
                'uuid' => Str::uuid(),

                'initial_flight_hour' => $stock_mutation_detail->mutation_detail_initial_aging->initial_flight_hour,
                'initial_block_hour' => $stock_mutation_detail->mutation_detail_initial_aging->initial_block_hour,
                'initial_flight_cycle' => $stock_mutation_detail->mutation_detail_initial_aging->initial_flight_cycle,
                'initial_flight_event' => $stock_mutation_detail->mutation_detail_initial_aging->initial_flight_event,
                'initial_start_date' => $stock_mutation_detail->mutation_detail_initial_aging->initial_start_date,
                
                'owned_by' => $request->user()->company_id,
                'status' => 1,
                'created_by' => $request->user()->id,
            ]);

            $Item_Stock->item_stock_initial_aging()->save($ItemStockInitialAging);
        }
        DB::commit();

        return response()->json(['success' => 'Stock Mutation Outbound Data has been Approved']);
    }
}
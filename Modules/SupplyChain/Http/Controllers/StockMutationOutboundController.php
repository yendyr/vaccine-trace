<?php

namespace Modules\SupplyChain\Http\Controllers;

use app\Helpers\SupplyChain\ItemStockMutation;
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
            $data = StockMutation::with(['origin','approvals'])
                                    ->whereNull('warehouse_destination');

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
        ItemStockMutation::deleteOutbound($MutationOutbound);
        return response()->json(['success' => 'Stock Mutation Outbound Data has been Deleted']);
    }

    public function approve(Request $request, StockMutation $MutationOutbound)
    {
        if ($MutationOutbound->outbound_mutation_details()->count() > 0) {
            $request->validate([
                'approval_notes' => ['required', 'max:30'],
            ]);
            
            ItemStockMutation::approveOutbound($request, $MutationOutbound);
            return response()->json(['success' => 'Stock Mutation Outbound Data has been Approved']);
        }
        else {
            return response()->json(['error' => "This Stock Mutation Outbound doesn't Have Any Detail Data"]);
        }
    }
}
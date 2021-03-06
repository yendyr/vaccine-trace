<?php

namespace Modules\SupplyChain\Http\Controllers;

use app\Helpers\SupplyChain\ItemStockMutation;
use Modules\SupplyChain\Entities\StockMutation;
use Modules\SupplyChain\Entities\InboundMutationDetail;
use Modules\Procurement\Entities\PurchaseOrderDetail;

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
            $data = StockMutation::with(['destination','supplier','approvals'])
                                ->whereNull('warehouse_origin');

            return Datatables::of($data)
            ->addColumn('reference', function($row){
                if ($row->inbound_mutation_details) {
                    $referenceCodeArray = array();
                    $reference_code = '';

                    $InboundMutationDetails = InboundMutationDetail::where('stock_mutation_id', $row->id)->get();
                    
                    foreach ($InboundMutationDetails as $InboundMutationDetail) {
                        if ($InboundMutationDetail->purchase_order_detail) {
                            $temp_code = "<a href='/procurement/purchase-order/" . $InboundMutationDetail->purchase_order_detail->purchase_order->id . "' target='_blank'>" . $InboundMutationDetail->purchase_order_detail->purchase_order->code . "</a>";
                            if (!in_array($temp_code, $referenceCodeArray)) {
                                $referenceCodeArray[] = $temp_code;
                            }
                        }
                    }

                    foreach ($referenceCodeArray as $code) {
                        $reference_code .= $code . ',<br>';
                    }
                    
                    $reference_code = Str::beforeLast($reference_code, ',');
                    return $reference_code;
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
            'supplier_id' => $request->supplier_id,

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

            if ($currentRow->supplier_id && ($request->supplier_id != $currentRow->supplier_id)) {
                if ($currentRow->inbound_mutation_details()->count() > 0) {
                    return response()->json(['error' => "This Stock Mutation Inbound Already has Prepared Detail Data Which Relate to Specific Supplier and Purchase Order, So You Can't Modify Supplier"]);
                }
            }

            $transaction_date = Carbon::parse($request->transaction_date);
        
            $currentRow->update([
                'transaction_date' => $transaction_date,
                'warehouse_destination' => $request->warehouse_destination,
                'description' => $request->description,
                'supplier_id' => $request->supplier_id,

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
        $StockMutation = StockMutation::where('id', $MutationInbound->id)->first();

        DB::beginTransaction();
        foreach($StockMutation->inbound_mutation_details as $inbound_mutation_detail) {
            if ($inbound_mutation_detail->purchase_order_detail_id) {
                $PurchaseOrderDetail = PurchaseOrderDetail::where('id', $inbound_mutation_detail->purchase_order_detail_id)->first();

                $PurchaseOrderDetail->update([
                    'prepared_to_grn_quantity' => $PurchaseOrderDetail->prepared_to_grn_quantity - $inbound_mutation_detail->quantity,
                ]);
            }

            $inbound_mutation_detail->mutation_detail_initial_aging()->delete();
            $inbound_mutation_detail->update([
                'deleted_by' => Auth::user()->id,
            ]);
            InboundMutationDetail::destroy($inbound_mutation_detail->id);
        }

        $StockMutation->update([
            'deleted_by' => Auth::user()->id,
        ]);

        StockMutation::destroy($MutationInbound->id);
        DB::commit();

        return response()->json(['success' => 'Stock Mutation Inbound Data has been Deleted']);
    }

    public function approve(Request $request, StockMutation $MutationInbound)
    {
        if ($MutationInbound->inbound_mutation_details()->count() > 0) {
            $request->validate([
                'approval_notes' => ['required', 'max:30'],
            ]);
    
            ItemStockMutation::approveInbound($request, $MutationInbound);
            return response()->json(['success' => 'Stock Mutation Inbound Data has been Approved']);
        }
        else {
            return response()->json(['error' => "This Stock Mutation Inbound doesn't Have Any Detail Data"]);
        }
    }
}
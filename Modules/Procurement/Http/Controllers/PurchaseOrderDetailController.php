<?php

namespace Modules\Procurement\Http\Controllers;

use Modules\Procurement\Entities\PurchaseOrder;
use Modules\Procurement\Entities\PurchaseOrderDetail;

use app\Helpers\SupplyChain\ItemStockChecker;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Yajra\DataTables\Facades\DataTables;

class PurchaseOrderDetailController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        // $this->authorizeResource(AircraftConfiguration::class, 'configuration_detail');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $purchase_order_id = $request->id;
        $PurchaseOrder = PurchaseOrder::where('id', $purchase_order_id)->first();

        $approved = false;
        if ($PurchaseOrder->approvals()->count() > 0) {
            $approved = true;
        }
        
        $data = PurchaseOrderDetail::where('purchase_order_id', $purchase_order_id)
                                ->with(['purchase_requisition_details.item.unit',
                                        'purchase_requisition_details.item_group:id,item_id,coding,parent_coding']);
        
        return Datatables::of($data)
        ->addColumn('available_stock', function($row){
            return ItemStockChecker::usable_item(null, $row->item->code);
        })
        ->addColumn('price_after_vat', function($row){
            return (($row->order_quantity * $row->each_price_before_vat) * $row->vat) + ($row->order_quantity * $row->price_before_vat);
        })
        ->addColumn('parent', function($row){
            if ($row->purchase_requisition_details->item_group) {
                return 'P/N: <strong>' . $row->purchase_requisition_details->item_group->item->code . '</strong><br>' . 
                'Name: <strong>' . $row->purchase_requisition_details->item_group->item->name . '</strong><br>';
            } 
            else {
                return "<span class='text-muted font-italic'>Not Set</span>";
            }
        })
        ->addColumn('creator_name', function($row){
            return $row->creator->name ?? '-';
        })
        ->addColumn('updater_name', function($row){
            return $row->updater->name ?? '-';
        })
        ->addColumn('action', function($row) use ($approved) {
            if ($row->purchase_requisition_details->parent_coding) {
                return "<span class='text-info font-italic'>this Item Included with its Parent</span>";
            }
            else if ($approved == false) {
                $noAuthorize = true;

                if(Auth::user()->can('update', PurchaseOrder::class)) {
                    $updateable = 'button';
                    $updateValue = $row->id;
                    $noAuthorize = false;
                }
                if(Auth::user()->can('delete', PurchaseOrder::class)) {
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
            }
            else if ($approved == true) {
                return '<p class="text-muted font-italic">Already Approved</p>';
            }
        })
        ->escapeColumns([])
        ->make(true);
    }

    public function tree(Request $request)
    {
        $purchase_order_id = $request->id;
        $datas = PurchaseOrderDetail::where('purchase_order_id', $purchase_order_id)
                                    ->with(['purchase_requisition_details.item.unit',
                                    'purchase_requisition_details.item_group:id,item_id,coding,parent_coding'])
                                    ->get();

        $response = [];
        foreach($datas as $data) {
            if ($data->purchase_requisition_details->parent_coding) {
                $parent = $data->purchase_requisition_details->parent_coding;
            }
            else {
                $parent = '#';
            }

            $response[] = [
                "id" => $data->purchase_requisition_details->coding,
                "parent" => $parent,
                "text" => 'P/N: <strong>' . $data->purchase_requisition_details->item->code . 
                '</strong> | Item Name: <strong>' . $data->purchase_requisition_details->item->name . 
                '</strong> | Order Qty: <strong>' . $data->order_quantity . '</strong>'
            ];
        }
        return response()->json($response);
    }

    public function store(Request $request)
    {
        $StockMutation = StockMutation::where('id', $request->stock_mutation_id)->first();

        if ($StockMutation->approvals()->count() == 0) {
            $request->validate([
                'stock_mutation_id' => ['required'],
                'item_stock_id' => ['required'],
                'outbound_quantity' => ['required'],
            ]);

            $item_stock = ItemStock::where('id', $request->item_stock_id)->first();
            
            if(($request->outbound_quantity > 0) && ($request->outbound_quantity <= $item_stock->available_quantity)) {
                $outbound_quantity = $request->outbound_quantity;
            }
            else {
                return response()->json(['error' => "Outbound Quantity Must be Greater than 0 and Less than Current Available Stock"]);
            }
    
            DB::beginTransaction();
            OutboundMutationDetail::create([
                'uuid' =>  Str::uuid(),
    
                'stock_mutation_id' => $request->stock_mutation_id,
                'item_stock_id' => $request->item_stock_id,
                'outbound_quantity' => $outbound_quantity,
                'description' => $request->outbound_remark,
    
                'owned_by' => $request->user()->company_id,
                'status' => 1,
                'created_by' => $request->user()->id,
            ]);
            $item_stock->update([
                'reserved_quantity' => $item_stock->reserved_quantity + $outbound_quantity,
            ]);
            if (sizeof($item_stock->all_childs) > 0) {
                ItemStockMutation::pickChildsForOutbound($item_stock, $request->stock_mutation_id);
            }
            DB::commit();
    
            return response()->json(['success' => 'Outbound Item/Component Data has been Added']);
        }
        else {
            return response()->json(['error' => "This Stock Mutation Outbound and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function update(Request $request, OutboundMutationDetail $MutationOutboundDetail)
    {
        $currentRow = OutboundMutationDetail::where('id', $MutationOutboundDetail->id)
                                        ->first();

        $StockMutation = StockMutation::where('id', $currentRow->stock_mutation_id)->first();

        if ($StockMutation->approvals()->count() == 0) {
            $request->validate([
                'stock_mutation_id' => ['required'],
                'item_stock_id' => ['required'],
                'outbound_quantity' => ['required'],
            ]);

            $item_stock = ItemStock::where('id', $request->item_stock_id)->first();

            $temporary_available_quantity = $item_stock->available_quantity + $currentRow->outbound_quantity;
        
            if(($request->outbound_quantity > 0) && ($request->outbound_quantity <= $temporary_available_quantity)) {
                $outbound_quantity = $request->outbound_quantity;
            }
            else {
                return response()->json(['error' => "Outbound Quantity Must be Greater than 0 and Less than Current Available Stock"]);
            }

            $outbound_quantity_gap = $outbound_quantity - $currentRow->outbound_quantity;
    
            DB::beginTransaction();
            $currentRow->update([
                'outbound_quantity' => $outbound_quantity,
                'description' => $request->outbound_remark,

                'updated_by' => Auth::user()->id,
            ]);
            $item_stock->update([
                'reserved_quantity' => $item_stock->reserved_quantity + $outbound_quantity_gap,

                'updated_by' => Auth::user()->id,
            ]);
            DB::commit();
            
            return response()->json(['success' => 'Item/Component Data has been Updated']);
        }
        else {
            return response()->json(['error' => "This Stock Mutation Outbound and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function destroy(OutboundMutationDetail $MutationOutboundDetail)
    {
        $StockMutation = StockMutation::where('id', $MutationOutboundDetail->stock_mutation_id)
                                    ->first();

        if ($StockMutation->approvals()->count() == 0) {
            ItemStockMutation::deleteOutboundDetailRow($MutationOutboundDetail);
            return response()->json(['success' => 'Outbound Item/Component Data has been Deleted']);
        }
        else {
            return response()->json(['error' => "This Stock Mutation Outbound and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }
}
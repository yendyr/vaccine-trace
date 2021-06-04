<?php

namespace Modules\Procurement\Http\Controllers;

use Modules\Procurement\Entities\PurchaseOrder;
use Modules\Procurement\Entities\PurchaseOrderDetail;
use Modules\Procurement\Entities\PurchaseRequisitionDetail;

use app\Helpers\SupplyChain\ItemStockChecker;
use Carbon\Carbon;

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
        $purchase_order_id = $request->purchase_order_id;
        $PurchaseOrder = PurchaseOrder::where('id', $purchase_order_id)->first();

        $approved = false;
        if ($PurchaseOrder->approvals()->count() > 0) {
            $approved = true;
        }
        
        $data = PurchaseOrderDetail::where('purchase_order_id', $purchase_order_id)
                                ->with(['purchase_requisition_detail.purchase_requisition',
                                        'purchase_requisition_detail.item',
                                        'purchase_requisition_detail.item.category',
                                        'purchase_requisition_detail.item.unit',
                                        'purchase_requisition_detail.item_group:id,item_id,coding,parent_coding']);
                                        
        return Datatables::of($data)
        ->addColumn('purchase_requisition_data', function($row){
            return "<a href='/procurement/purchase-requisition/" . 
            $row->purchase_requisition_detail->purchase_requisition->id . "' target='_blank'>" . 
            $row->purchase_requisition_detail->purchase_requisition->code . '</a>';
        })
        ->addColumn('available_stock', function($row){
            return ItemStockChecker::usable_item(null, $row->purchase_requisition_detail->item->code);
        })
        ->addColumn('price_after_vat', function($row){
            return (($row->order_quantity * $row->each_price_before_vat) * $row->vat) + ($row->order_quantity * $row->each_price_before_vat);
        })
        ->addColumn('parent', function($row){
            if ($row->purchase_requisition_detail->item_group) {
                return 'P/N: <strong>' . $row->purchase_requisition_detail->item_group->item->code . '</strong><br>' . 
                'Name: <strong>' . $row->purchase_requisition_detail->item_group->item->name . '</strong><br>';
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
            if ($row->purchase_requisition_detail->parent_coding) {
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
        $purchase_order_id = $request->purchase_order_id;
        $datas = PurchaseOrderDetail::with(['purchase_requisition_detail',
                                    'purchase_requisition_detail.item',
                                    'purchase_requisition_detail.item.unit',
                                    'purchase_requisition_detail.item_group:id,item_id,coding,parent_coding'])
                                    ->where('purchase_order_id', $purchase_order_id)
                                    ->get();
        $response = [];
        foreach($datas as $data) {
            if ($data->purchase_requisition_detail->parent_coding) {
                $parent = $data->purchase_requisition_detail->parent_coding;
            }
            else {
                $parent = '#';
            }

            $response[] = [
                "id" => $data->purchase_requisition_detail->coding,
                "parent" => $parent,
                "text" => 'P/N: <strong>' . $data->purchase_requisition_detail->item->code . 
                '</strong> | Item Name: <strong>' . $data->purchase_requisition_detail->item->name . 
                '</strong> | Order Qty: <strong>' . $data->order_quantity . '</strong>'
            ];
        }
        return response()->json($response);
    }

    public function store(Request $request)
    {
        $PurchaseOrder = PurchaseOrder::where('id', $request->purchase_order_id)->first();

        if ($PurchaseOrder->approvals()->count() == 0) {
            $request->validate([
                'purchase_order_id' => ['required'],
                'purchase_requisition_detail_id' => ['required'],
                'order_quantity' => ['required'],
                'each_price_before_vat' => ['required'],
                'vat' => ['required'],
            ]);

            $PurchaseRequisitionDetail = PurchaseRequisitionDetail::where('id', $request->purchase_requisition_detail_id)->first();
            
            if(($request->order_quantity > 0) && 
            ($request->order_quantity <= $PurchaseRequisitionDetail->request_quantity - ($PurchaseRequisitionDetail->prepared_to_po_quantity + $PurchaseRequisitionDetail->processed_to_po_quantity))) {
                $order_quantity = $request->order_quantity;
            }
            else {
                return response()->json(['error' => "Order Quantity Must be Greater than 0 and Less than Requested Quantity"]);
            }

            $required_delivery_date = Carbon::parse($request->required_delivery_date);
            $vat = $request->vat / 100;
    
            DB::beginTransaction();
            PurchaseOrderDetail::create([
                'uuid' =>  Str::uuid(),
    
                'purchase_order_id' => $request->purchase_order_id,
                'purchase_requisition_detail_id' => $request->purchase_requisition_detail_id,
                'required_delivery_date' => $required_delivery_date,
                'order_quantity' => $order_quantity,
                'each_price_before_vat' => $request->each_price_before_vat,
                'vat' => $vat,
                'description' => $request->order_remark,
    
                'owned_by' => $request->user()->company_id,
                'status' => 1,
                'created_by' => $request->user()->id,
            ]);
            $PurchaseRequisitionDetail->update([
                'prepared_to_po_quantity' => $PurchaseRequisitionDetail->prepared_to_po_quantity + $order_quantity,
            ]);
            $PurchaseOrder->update([
                'total_before_vat' => $PurchaseOrder->total_before_vat + ($request->each_price_before_vat * $order_quantity),
                'total_after_vat' => $PurchaseOrder->total_after_vat + (($request->each_price_before_vat * $order_quantity) * $vat + ($request->each_price_before_vat * $order_quantity)),
            ]);
            if (sizeof($PurchaseRequisitionDetail->all_childs) > 0) {
                Self::pickChildsForPurchaseOrder($PurchaseRequisitionDetail, $request->purchase_order_id, $required_delivery_date);
            }
            DB::commit();
    
            return response()->json(['success' => 'Item/Component Data has been Added']);
        }
        else {
            return response()->json(['error' => "This Purchase Order and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public static function pickChildsForPurchaseOrder($PurchaseRequisitionDetail, $purchase_order_id, $required_delivery_date)
    {
        foreach($PurchaseRequisitionDetail->all_childs as $childRow) {
            PurchaseOrderDetail::create([
                'uuid' =>  Str::uuid(),
    
                'purchase_order_id' => $purchase_order_id,
                'purchase_requisition_detail_id' => $childRow->id,
                'required_delivery_date' => $required_delivery_date,
                'order_quantity' => $childRow->request_quantity,
    
                'owned_by' => Auth::user()->company_id,
                'status' => 1,
                'created_by' => Auth::user()->id,
            ]);
            $childRow->update([
                'prepared_to_po_quantity' => $childRow->request_quantity,

                'updated_by' => Auth::user()->id,
            ]);
            if (sizeof($childRow->all_childs) > 0) {
                Self::pickChildsForPurchaseOrder($childRow, $purchase_order_id, $required_delivery_date);
            }
        }
    }

    public function update(Request $request, PurchaseOrderDetail $PurchaseOrderDetail)
    {
        $PurchaseOrder = PurchaseOrder::where('id', $PurchaseOrderDetail->purchase_order_id)
                                    ->first();

        if ($PurchaseOrder->approvals()->count() == 0) {
            $request->validate([
                'purchase_order_id' => ['required'],
                'purchase_requisition_detail_id' => ['required'],
                'order_quantity' => ['required'],
                'each_price_before_vat' => ['required'],
                'vat' => ['required'],
            ]);

            $PurchaseRequisitionDetail = PurchaseRequisitionDetail::where('id', $request->purchase_requisition_detail_id)->first();

            $temp_available_request = ($PurchaseRequisitionDetail->request_quantity + $PurchaseOrderDetail->order_quantity) - ($PurchaseRequisitionDetail->prepared_to_po_quantity + $PurchaseRequisitionDetail->processed_to_po_quantity);
            
            if(($request->order_quantity > 0) && 
            ($request->order_quantity <= $temp_available_request)) {
                $order_quantity = $request->order_quantity;
            }
            else {
                return response()->json(['error' => "Order Quantity Must be Greater than 0 and Less than Requested Quantity"]);
            }

            $required_delivery_date = Carbon::parse($request->required_delivery_date);
            $vat = $request->vat / 100;

            $order_quantity_gap = $order_quantity - $PurchaseOrderDetail->order_quantity;

            DB::beginTransaction();
            $PurchaseOrderDetail->update([
                'required_delivery_date' => $required_delivery_date,
                'order_quantity' => $order_quantity,
                'each_price_before_vat' => $request->each_price_before_vat,
                'vat' => $vat,
                'description' => $request->order_remark,

                'updated_by' => Auth::user()->id,
            ]);
            $PurchaseRequisitionDetail->update([
                'prepared_to_po_quantity' => $PurchaseRequisitionDetail->prepared_to_po_quantity + $order_quantity_gap,

                'updated_by' => Auth::user()->id,
            ]);
            DB::commit();
            
            return response()->json(['success' => 'Item/Component Data has been Updated']);
        }
        else {
            return response()->json(['error' => "This Purchase Order and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function destroy(PurchaseOrderDetail $PurchaseOrderDetail)
    {
        $PurchaseOrder = PurchaseOrder::where('id', $PurchaseOrderDetail->purchase_order_id)
                                    ->first();

        if ($PurchaseOrder->approvals()->count() == 0) {
            Self::deletePurchaseOrderDetailRow($PurchaseOrder, $PurchaseOrderDetail);
            return response()->json(['success' => 'Item/Component Data has been Deleted']);
        }
        else {
            return response()->json(['error' => "This Purchase Order and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public static function deletePurchaseOrderDetailRow($PurchaseOrderRow, $PurchaseOrderDetailRow)
    {
        $PurchaseOrderDetailRow = PurchaseOrderDetail::where('id', $PurchaseOrderDetailRow->id)
                                                    ->with(['purchase_requisition_detail.all_childs'])
                                                    ->first();

        $purchase_requisition_detail = PurchaseRequisitionDetail::where('id', $PurchaseOrderDetailRow->purchase_requisition_detail_id)->first();

        DB::beginTransaction();
        if (sizeof($purchase_requisition_detail->all_childs) > 0) {
            Self::unpickChildsForPurchaseOrderDetail($purchase_requisition_detail, $PurchaseOrderDetailRow->purchase_requisition_detail_id);
        }
        $PurchaseOrderDetailRow->update([
            'deleted_by' => Auth::user()->id,
        ]);
        
        $purchase_requisition_detail->update([
            'prepared_to_po_quantity' => $purchase_requisition_detail->prepared_to_po_quantity - $PurchaseOrderDetailRow->order_quantity,

            'updated_by' => Auth::user()->id,
        ]);

        // $PurchaseOrderRow->update([
        //     'total_before_vat' => $PurchaseOrderRow->total_before_vat - ($PurchaseOrderDetailRow->each_price_before_vat * $PurchaseOrderDetailRow->order_quantity),
        //     'total_after_vat' => $PurchaseOrderRow->total_after_vat - (($PurchaseOrderDetailRow->each_price_before_vat * $PurchaseOrderDetailRow->order_quantity) * $vat + ($PurchaseOrderDetailRow->each_price_before_vat * $PurchaseOrderDetailRow->order_quantity)),

        //     'updated_by' => Auth::user()->id,
        // ]);

        PurchaseOrderDetail::destroy($PurchaseOrderDetailRow->id);
        DB::commit();
    }

    public static function unpickChildsForPurchaseOrderDetail($purchase_requisition_detail, $purchase_requisition_detail_id)
    {
        foreach($purchase_requisition_detail->all_childs as $childRow) {
            $childRow->update([
                'prepared_to_po_quantity' => 0,

                'updated_by' => Auth::user()->id,
            ]);

            $PurchaseOrderDetailRow = PurchaseOrderDetail::where('purchase_requisition_detail_id', $childRow->id)->first();

            $PurchaseOrderDetailRow->update([
                'deleted_by' => Auth::user()->id,
            ]);
            PurchaseOrderDetail::destroy($PurchaseOrderDetailRow->id);
            
            if (sizeof($childRow->all_childs) > 0) {
                Self::unpickChildsForPurchaseOrderDetail($childRow, $purchase_requisition_detail_id);
            }
        }
    }
}
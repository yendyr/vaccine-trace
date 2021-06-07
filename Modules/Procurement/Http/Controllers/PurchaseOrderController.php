<?php

namespace Modules\Procurement\Http\Controllers;

use Modules\Procurement\Entities\PurchaseOrder;
use Modules\Procurement\Entities\PurchaseRequisitionDetail;
use Modules\Procurement\Entities\PurchaseOrderDetail;
use Modules\Procurement\Entities\PurchaseOrderApproval;

use app\Helpers\Procurement\PurchaseOrderPrice;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;

class PurchaseOrderController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(PurchaseOrder::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PurchaseOrder::with(['approvals',
                                        'purchase_order_details',
                                        'purchase_order_details.purchase_requisition_detail.purchase_requisition',
                                        'supplier:id,code,name',
                                        'current_primary_currency:id,code,symbol,name',
                                        'currency:id,code,symbol,name']);

            return Datatables::of($data)
            ->addColumn('reference', function($row){
                if ($row->purchase_order_details) {
                    $referenceCodeArray = array();
                    $reference_code = '';

                    $PurchaseOrderDetails = PurchaseOrderDetail::where('purchase_order_id', $row->id)->get();
                    
                    foreach ($PurchaseOrderDetails as $PurchaseOrderDetail) {
                        if (!in_array($PurchaseOrderDetail->purchase_requisition_detail->purchase_requisition->code, $referenceCodeArray)) {
                            $referenceCodeArray[] = $PurchaseOrderDetail->purchase_requisition_detail->purchase_requisition->code;
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
            ->addColumn('total_price_before_tax', function($row){
                return PurchaseOrderPrice::totalPriceBeforeTax($row->id);
            })
            ->addColumn('total_price_after_tax', function($row){
                return PurchaseOrderPrice::totalPriceAfterTax($row->id);
            })
            ->addColumn('action', function($row){
                $noAuthorize = true;
                $updateable = null;
                $updateValue = null;
                $deleteable = null;
                $deleteId = null;
                $approvable = null;
                $approveId = null;

                if ($row->approvals()->count() > 0) {
                    return '<p class="text-muted font-italic">Already Approved</p>';
                }
                else {
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
                    if(Auth::user()->can('approval', PurchaseOrder::class)) {
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
        return view('procurement::pages.purchase-order.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => ['required', 'max:30'],
            'supplier_id' => ['required', 'max:30'],
            'current_primary_currency_id' => ['required', 'max:30'],
            'currency_id' => ['required', 'max:30'],
            'exchange_rate' => ['required', 'max:30'],
            // 'description' => ['required'],
        ]);

        $transaction_date = Carbon::parse($request->transaction_date);
        $valid_until_date = Carbon::parse($request->valid_until_date);

        DB::beginTransaction();
        $PurchaseOrder = PurchaseOrder::create([
            'uuid' =>  Str::uuid(),

            'transaction_date' => $transaction_date,
            'valid_until_date' => $valid_until_date,
            'shipping_address' => $request->shipping_address,
            'supplier_id' => $request->supplier_id,
            'supplier_reference_document' => $request->supplier_reference_document,
            'description' => $request->description,
            'term_and_condition' => $request->term_and_condition,

            'current_primary_currency_id' => $request->current_primary_currency_id,
            'currency_id' => $request->currency_id,
            'exchange_rate' => $request->exchange_rate,

            'status' => 1,
            'owned_by' => $request->user()->company_id,
            'created_by' => $request->user()->id,
        ]);

        $code = 'PCORD-' . 
        $transaction_date->year . '-' .
        str_pad($PurchaseOrder->id, 5, '0', STR_PAD_LEFT);

        $PurchaseOrder->update([
            'code' => $code
        ]);
        DB::commit();
    
        return response()->json(['success' => 'Purchase Order Data has been Saved',
                                    'id' => $PurchaseOrder->id]);
    }

    public function show(PurchaseOrder $PurchaseOrder)
    {
        return view('procurement::pages.purchase-order.show', compact('PurchaseOrder'));
    }

    public function update(Request $request, PurchaseOrder $PurchaseOrder)
    {
        $currentRow = PurchaseOrder::where('id', $PurchaseOrder->id)->first();
        if ($currentRow->approvals()->count() == 0) {
            $request->validate([
                'transaction_date' => ['required', 'max:30'],
                'supplier_id' => ['required', 'max:30'],
                'current_primary_currency_id' => ['required', 'max:30'],
                'currency_id' => ['required', 'max:30'],
                'exchange_rate' => ['required', 'max:30'],
                // 'description' => ['required'],
            ]);

            $transaction_date = Carbon::parse($request->transaction_date);
            $valid_until_date = Carbon::parse($request->valid_until_date);
        
            $currentRow->update([
                'transaction_date' => $transaction_date,
                'valid_until_date' => $valid_until_date,
                'shipping_address' => $request->shipping_address,
                'supplier_id' => $request->supplier_id,
                'supplier_reference_document' => $request->supplier_reference_document,
                'description' => $request->description,
                'term_and_condition' => $request->term_and_condition,

                'current_primary_currency_id' => $request->current_primary_currency_id,
                'currency_id' => $request->currency_id,
                'exchange_rate' => $request->exchange_rate,

                'updated_by' => Auth::user()->id,
            ]);
            
            return response()->json(['success' => 'Purchase Order Data has been Updated',
                                        'id' => $PurchaseOrder->id]);
        }
        else {
            return response()->json(['error' => "This Purchase Order and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function destroy(PurchaseOrder $PurchaseOrder)
    {
        Self::deletePurchaseOrder($PurchaseOrder);
        return response()->json(['success' => 'Purchase Order Data has been Deleted']);
    }

    public static function deletePurchaseOrder($PurchaseOrder)
    {
        DB::beginTransaction();
        foreach($PurchaseOrder->purchase_order_details as $purchase_order_detail) {
            $PurchaseRequisitionDetail = PurchaseRequisitionDetail::where('id', $purchase_order_detail->purchase_requisition_detail_id)->first();

            $purchase_order_detail->update([
                'deleted_by' => Auth::user()->id,
            ]);
            PurchaseRequisitionDetail::destroy($purchase_order_detail->id);
            $PurchaseRequisitionDetail->update([
                'prepared_to_po_quantity' => $PurchaseRequisitionDetail->prepared_to_po_quantity - $purchase_order_detail->order_quantity,

                // 'updated_by' => Auth::user()->id,
            ]);
        }

        $PurchaseOrder->update([
            'deleted_by' => Auth::user()->id,
        ]);

        PurchaseOrder::destroy($PurchaseOrder->id);
        DB::commit();
    }

    public function approve(Request $request, PurchaseOrder $PurchaseOrder)
    {
        if ($PurchaseOrder->purchase_order_details()->count() > 0) {
            $request->validate([
                'approval_notes' => ['required', 'max:30'],
            ]);
            
            Self::approvePurchaseOrder($request, $PurchaseOrder);
            return response()->json(['success' => 'Purchase Order Data has been Approved']);
        }
        else {
            return response()->json(['error' => "This Purchase Order doesn't Have Any Detail Data"]);
        }
    }

    public static function approvePurchaseOrder($request, $PurchaseOrder)
    {
        DB::beginTransaction();
        PurchaseOrderApproval::create([
            'uuid' =>  Str::uuid(),

            'purchase_order_id' =>  $PurchaseOrder->id,
            'approval_notes' =>  $request->approval_notes,
    
            'owned_by' => $request->user()->company_id,
            'status' => 1,
            'created_by' => Auth::user()->id,
        ]);

        foreach($PurchaseOrder->purchase_order_details as $purchase_order_detail) {
            $PurchaseRequisitionDetail = PurchaseRequisitionDetail::where('id', $purchase_order_detail->purchase_requisition_detail_id)->first();

            $PurchaseRequisitionDetail->update([
                'processed_to_po_quantity' => $PurchaseRequisitionDetail->processed_to_po_quantity + $purchase_order_detail->order_quantity,
                'prepared_to_po_quantity' => $PurchaseRequisitionDetail->prepared_to_po_quantity - $purchase_order_detail->order_quantity,

                'updated_by' => Auth::user()->id,
            ]);
        }
        DB::commit();
    }
}
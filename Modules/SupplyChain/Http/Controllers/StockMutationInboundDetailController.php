<?php

namespace Modules\SupplyChain\Http\Controllers;

use Modules\SupplyChain\Entities\StockMutation;
use Modules\SupplyChain\Entities\InboundMutationDetail;
use Modules\SupplyChain\Entities\InboundMutationDetailInitialAging;
use Modules\Procurement\Entities\PurchaseRequisitionDetail;
use Modules\Procurement\Entities\PurchaseOrderDetail;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class StockMutationInboundDetailController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        // $this->authorizeResource(AircraftConfiguration::class, 'configuration_detail');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $stock_mutation_id = $request->id;
        $StockMutation = StockMutation::where('id', $stock_mutation_id)->first();

        $approved = false;
        if ($StockMutation->approvals()->count() > 0) {
            $approved = true;
        }
        
        $data = InboundMutationDetail::where('stock_mutation_id', $stock_mutation_id)
                                ->with(['item.unit',
                                        'item.category',
                                        'mutation_detail_initial_aging',
                                        'purchase_order_detail.purchase_order',
                                        'item_group:id,item_id,serial_number,alias_name,coding,parent_coding',
                                        'item_group.item']);
        
        return Datatables::of($data)
        ->addColumn('highlighted', function($row){
            if ($row->highlight == 1){
                return '<label class="label label-primary">Yes</label>';
            } else{
                return '<label class="label label-danger">No</label>';
            }
        })
        ->addColumn('parent', function($row){
            if ($row->item_group) {
                return 'P/N: <strong>' . $row->item_group->item->code . '</strong><br>' . 
                'S/N: <strong>' . $row->item_group->serial_number . '</strong><br>' .
                'Name: <strong>' . $row->item_group->item->name . '</strong><br>' .
                'Alias: <strong>' . $row->item_group->alias_name . '</strong><br>';
            } 
            else {
                return "<span class='text-muted font-italic'>Not Set</span>";
            }
        })
        ->addColumn('purchase_order_data', function($row){
            if ($row->purchase_order_detail) {
                return "<a href='/procurement/purchase-order/" . 
                $row->purchase_order_detail->purchase_order->id . "' target='_blank'>" . 
                $row->purchase_order_detail->purchase_order->code . '</a>';
            }
            else {
                return '-';
            }
        })
        ->addColumn('creator_name', function($row){
            return $row->creator->name ?? '-';
        })
        // ->addColumn('updater_name', function($row){
        //     return $row->updater->name ?? '-';
        // })
        // ->addColumn('qr_code', function($row) use ($approved) {
        //     if ($approved == true) {
                
        //     }
        //     else {
        //         return '-';
        //     }
        // })
        ->addColumn('action', function($row) use ($approved) {
            // if ($row->item_group && $row->purchase_order_detail) {
            //     return "<span class='text-info font-italic'>this Item Included with its Parent</span>";
            // }
            if ($approved == false) {
                $noAuthorize = true;
                $updateable = null;
                $updateValue = null;
                $deleteable = null;
                $deleteId = null;

                // if (Auth::user()->can('update', StockMutation::class) && (!$row->purchase_order_detail_id)) {
                //     $updateable = 'button';
                //     $updateValue = $row->id;
                //     $noAuthorize = false;
                // }
                if (Auth::user()->can('update', StockMutation::class)) {
                    $updateable = 'button';
                    $updateValue = $row->id;
                    $noAuthorize = false;
                }
                if (Auth::user()->can('delete', StockMutation::class) && (!$row->purchase_order_detail_id || !$row->parent_coding )) {
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
            else {
                // return '<p class="text-muted font-italic">Already Approved</p>';
                $printSingleQr = 'button';
                $printSingleQrId = $row->uuid;
    
                return view('components.action-button', compact(['printSingleQr', 'printSingleQrId']));
            }
        })
        ->escapeColumns([])
        ->make(true);
    }

    public function tree(Request $request)
    {
        $stock_mutation_id = $request->id;
        $datas = InboundMutationDetail::where('stock_mutation_id', $stock_mutation_id)
                                ->with(['item.unit',
                                        'item_group:id,item_id,alias_name,coding,parent_coding'])
                                ->get();

        $response = [];
        foreach($datas as $data) {
            if ($data->parent_coding) {
                $parent = $data->parent_coding;
            }
            else {
                $parent = '#';
            }

            $response[] = [
                "id" => $data->coding,
                "parent" => $parent,
                "text" => 'P/N: <strong>' . $data->item->code . 
                '</strong> | Item Name: <strong>' . $data->item->name . 
                '</strong> | Serial Number: <strong>' . $data->serial_number . 
                '</strong> | Alias Name: <strong>' . $data->alias_name .
                '</strong> | Inbound Qty: <strong>' . $data->quantity . ' ' .
                $data->item->unit->name . '</strong>'
            ];
        }
        return response()->json($response);
    }

    public function store(Request $request)
    {
        $StockMutation = StockMutation::where('id', $request->stock_mutation_id)->first();

        if ($StockMutation->approvals()->count() == 0) {
            if (!$request->purchase_order_detail_id) {
                $request->validate([
                    'item_id' => ['required'],
                ]);
                $item_id = $request->item_id;
                $each_price_before_vat = 0;
            }
            else if ($request->purchase_order_detail_id) {
                $PurchaseOrderDetail = PurchaseOrderDetail::where('id', $request->purchase_order_detail_id)
                ->with(['purchase_requisition_detail'])
                ->first();

                $item_id = $PurchaseOrderDetail->purchase_requisition_detail->item_id;
                $each_price_before_vat = $PurchaseOrderDetail->each_price_before_vat_primary_currency;

                $PurchaseRequisitionDetail = PurchaseRequisitionDetail::with(['all_childs','purchase_order_details'])
                            ->where('id', $PurchaseOrderDetail->purchase_requisition_detail_id)
                            ->first();
            }

            if($request->quantity > 1) {
                $quantity = $request->quantity;
                $serial_number = null;
            }
            else {
                $quantity = 1;
                $serial_number = $request->serial_number;
            }

            $detailed_item_location = $request->detailed_item_location;
            $parent_coding = null;
            
            if ($request->parent_coding) {
                $parent_coding = $request->parent_coding;
                $parentRow = InboundMutationDetail::where('coding', $parent_coding)->first();
                $detailed_item_location = $parentRow->detailed_item_location;
            }
            
            if ($request->highlight) {
                $highlight = 1;
            } 
            else {
                $highlight = 0;
            }
    
            $initial_start_date = $request->initial_start_date;
            $expired_date = $request->expired_date;
    
            DB::beginTransaction();
            $InboundMutationDetail = InboundMutationDetail::create([
                'uuid' =>  Str::uuid(),
    
                'stock_mutation_id' => $request->stock_mutation_id,
                'purchase_order_detail_id' => $request->purchase_order_detail_id,

                'item_id' => $item_id,
                'quantity' => $quantity,
                'serial_number' => $serial_number,
                'alias_name' => $request->alias_name,
                'highlight' => $highlight,
                'description' => $request->description,
                'detailed_item_location' => $detailed_item_location,
                'parent_coding' => $parent_coding,
                'each_price_before_vat' => $each_price_before_vat,
    
                'owned_by' => $request->user()->company_id,
                'status' => 1,
                'created_by' => $request->user()->id,
            ]);
            $InboundMutationDetail->update([
                'coding' => $StockMutation->warehouse_destination . '-' . $InboundMutationDetail->id,
            ]);
            $InboundMutationDetail->mutation_detail_initial_aging()
                ->save(new InboundMutationDetailInitialAging([
                    'uuid' => Str::uuid(),

                    'initial_flight_hour' => $request->initial_flight_hour,
                    'initial_block_hour' => $request->initial_block_hour,
                    'initial_flight_cycle' => $request->initial_flight_cycle,
                    'initial_flight_event' => $request->initial_flight_event,
                    'initial_start_date' => $initial_start_date,
                    'expired_date' => $expired_date,
                    
                    'owned_by' => $request->user()->company_id,
                    'status' => 1,
                    'created_by' => $request->user()->id,
                ])
            );
            if ($request->purchase_order_detail_id) {
                $PurchaseOrderDetail->update([
                    'prepared_to_grn_quantity' => $PurchaseOrderDetail->prepared_to_grn_quantity + $quantity,
                ]);

                if (sizeof($PurchaseRequisitionDetail->all_childs) > 0) {
                    Self::pickChildsForInbound($PurchaseRequisitionDetail, $request->stock_mutation_id, $StockMutation->warehouse_destination, $highlight, $detailed_item_location, $InboundMutationDetail->coding);
                }
            }   
            DB::commit();
    
            return response()->json(['success' => 'Item/Component Data has been Added']);
        }
        else {
            return response()->json(['error' => "This Stock Mutation Inbound and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public static function pickChildsForInbound($PurchaseRequisitionDetail, $stock_mutation_id, $warehouse_destination, $highlight, $detailed_item_location, $parent_coding)
    {
        foreach($PurchaseRequisitionDetail->all_childs as $childRow) {
            $createChild = InboundMutationDetail::create([
                'uuid' =>  Str::uuid(),

                'stock_mutation_id' => $stock_mutation_id,
                'purchase_order_detail_id' => $childRow->purchase_order_details
                                                        ->first()
                                                        ->id,

                'item_id' => $childRow->item_id,
                'quantity' => $childRow->request_quantity,
                // 'serial_number' => $serial_number,
                // 'alias_name' => $request->alias_name,
                'highlight' => $highlight,
                // 'description' => $request->description,
                'detailed_item_location' => $detailed_item_location,
                'parent_coding' => $parent_coding,
                'each_price_before_vat' => $childRow->purchase_order_details
                                                    ->first()
                                                    ->each_price_before_vat,
    
                'owned_by' => Auth::user()->company_id,
                'status' => 1,
                'created_by' => Auth::user()->id,
            ]);
            $createChild->update([
                'coding' => $warehouse_destination . '-' . $createChild->id,
            ]);
            $createChild->mutation_detail_initial_aging()
                ->save(new InboundMutationDetailInitialAging([
                    'uuid' => Str::uuid(),

                    'initial_flight_hour' => null,
                    'initial_block_hour' => null,
                    'initial_flight_cycle' => null,
                    'initial_flight_event' => null,
                    'initial_start_date' => null,
                    'expired_date' => null,
                    
                    'owned_by' => Auth::user()->company_id,
                    'status' => 1,
                    'created_by' => Auth::user()->id,
                ])
            );
            $childRow->purchase_order_details->first()->update([
                'prepared_to_grn_quantity' => $childRow->request_quantity,
            ]);
            if (sizeof($childRow->all_childs) > 0) {
                Self::pickChildsForInbound($childRow, $stock_mutation_id, $warehouse_destination, $highlight, $detailed_item_location, $createChild->coding);
            }
        }
    }

    public function update(Request $request, InboundMutationDetail $MutationInboundDetail)
    {
        $currentRow = InboundMutationDetail::where('id', $MutationInboundDetail->id)
                                        ->with('all_childs')
                                        ->first();

        $StockMutation = StockMutation::where('id', $currentRow->stock_mutation_id)->first();

        if ($StockMutation->approvals()->count() == 0) {
            if (!$currentRow->purchase_order_detail_id) {
                $request->validate([
                    'item_id' => ['required'],
                ]);
            }
            
            if($request->quantity > 1) {
                if (sizeof($currentRow->all_childs) > 0) {
                    return response()->json(['error' => "This Item/Component has Child(s) Item, You Can't Set Quantity Larger than 1"]);
                }
                else {
                    $quantity = $request->quantity;
                    $serial_number = null;
                }
            }
            else {
                $quantity = 1;
                $serial_number = $request->serial_number;
            }

            if ($request->highlight) {
                $highlight = 1;
            } 
            else {
                $highlight = 0;
            }
    
            $parent_coding = null;
            $initial_start_date = $request->initial_start_date;
            $expired_date = $request->expired_date;
            $detailed_item_location = $request->detailed_item_location;
            
            if ($request->parent_coding) {
                if (Self::isValidParent($currentRow, $request->parent_coding)) {
                    if ($request->parent_coding != $currentRow->coding) {
                        $parent_coding = $request->parent_coding;
                        $parentRow = InboundMutationDetail::where('coding', $parent_coding)->first();
                        $detailed_item_location = $parentRow->detailed_item_location;
                    }
                }
                else {
                    return response()->json(['error' => "The Choosen Parent is Already in Child of this Item"]);
                }
            }
    
            DB::beginTransaction();
            if ($currentRow->purchase_order_detail_id) {
                $currentRow->update([
                    'alias_name' => $request->alias_name,
                    'serial_number' => $serial_number,
                    'highlight' => $highlight,
                    'description' => $request->description,
                    'detailed_item_location' => $detailed_item_location,
    
                    'updated_by' => Auth::user()->id,
                ]);
            }
            else {
                $currentRow->update([
                    'item_id' => $request->item_id,
                    'alias_name' => $request->alias_name,
                    'quantity' => $quantity,
                    'serial_number' => $serial_number,
                    'highlight' => $highlight,
                    'description' => $request->description,
                    'detailed_item_location' => $detailed_item_location,
                    'parent_coding' => $parent_coding,
    
                    'updated_by' => Auth::user()->id,
                ]);
            }
            if (sizeof($currentRow->all_childs) > 0) {
                Self::updateChilds($currentRow, $detailed_item_location);
            }
            $currentRow->mutation_detail_initial_aging()->update([
                'initial_flight_hour' => $request->initial_flight_hour,
                'initial_block_hour' => $request->initial_block_hour,
                'initial_flight_cycle' => $request->initial_flight_cycle,
                'initial_flight_event' => $request->initial_flight_event,
                'initial_start_date' => $initial_start_date,
                'expired_date' => $expired_date,
                
                'updated_by' => $request->user()->id,
            ]);
            DB::commit();
            
            return response()->json(['success' => 'Item/Component Data has been Updated']);
        }
        else {
            return response()->json(['error' => "This Stock Mutation Inbound and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public static function updateChilds($currentRow, $detailed_item_location)
    {
        foreach($currentRow->all_childs as $childRow) {
            $childRow->update([
                'detailed_item_location' => $detailed_item_location,
                'updated_by' => Auth::user()->id,
            ]);
            if (sizeof($childRow->all_childs) > 0) {
                Self::updateChilds($childRow, $detailed_item_location);
            }
        }
    }

    public static function isValidParent($currentRow, $parent_coding)
    {
        $isValid = true;
        foreach($currentRow->all_childs as $childRow) {
            if ($parent_coding == $childRow->coding) {
                $isValid = false;
                return $isValid;
                break;
            }
            else if (sizeof($childRow->all_childs) > 0) {
                Self::isValidParent($childRow, $parent_coding);
            }
        }
        return $isValid;
    }

    public function destroy(InboundMutationDetail $MutationInboundDetail)
    {
        $currentRow = InboundMutationDetail::where('id', $MutationInboundDetail->id)
                                        ->with(['all_childs'])
                                        ->first();

        $StockMutation = StockMutation::where('id', $currentRow->stock_mutation_id)->first();

        if ($StockMutation->approvals()->count() == 0) {
            if (sizeof($currentRow->all_childs) > 0 && !$currentRow->purchase_order_detail_id) {
                return response()->json(['error' => "This Item/Component has Child(s) Item, You Can't Directly Delete this Item/Component"]);
            }
            else if (!$currentRow->purchase_order_detail_id) {
                $currentRow->update([
                    'deleted_by' => Auth::user()->id,
                ]);
                InboundMutationDetail::destroy($MutationInboundDetail->id);
                return response()->json(['success' => 'Item/Component Data has been Deleted']);
            }
            else {
                $PurchaseOrderDetail = PurchaseOrderDetail::where('id', $currentRow->purchase_order_detail_id)->first();

                // $PurchaseRequisitionDetail = PurchaseRequisitionDetail::with(['all_childs','purchase_order_details'])
                //             ->where('id', $PurchaseOrderDetail->purchase_requisition_detail_id)
                //             ->first();

                DB::beginTransaction();
                if (sizeof($currentRow->all_childs) > 0) {
                    Self::unpickChilds($currentRow);
                }

                $currentRow->update([
                    'deleted_by' => Auth::user()->id,
                ]);
                $PurchaseOrderDetail->update([
                    'prepared_to_grn_quantity' => $PurchaseOrderDetail->prepared_to_grn_quantity - $currentRow->quantity,
                ]);
                InboundMutationDetail::destroy($MutationInboundDetail->id);
                DB::commit();

                return response()->json(['success' => 'Item/Component Data has been Deleted']);
            }
        }
        else {
            return response()->json(['error' => "This Stock Mutation Inbound and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public static function unpickChilds($currentRow)
    {
        foreach($currentRow->all_childs as $childRow) {
            $purchaseOrderDetailRow = PurchaseOrderDetail::where('id', $childRow->purchase_order_detail_id)->first();

            $childRow->update([
                'deleted_by' => Auth::user()->id,
            ]);
            $purchaseOrderDetailRow->update([
                'prepared_to_grn_quantity' => 0,
            ]);
            InboundMutationDetail::destroy($childRow->id);
            
            if (sizeof($childRow->all_childs) > 0) {
                Self::unpickChilds($childRow);
            }
        }
    }

    public function select2Parent(Request $request)
    {
        $search = $request->term;
        $stock_mutation_id = $request->stock_mutation_id;

        if($search != '') {
            $InboundMutationDetails = InboundMutationDetail::with(['item' => function($q) use ($search) {
                                            $q->where('items.code', 'like', '%' .$search. '%')
                                            ->orWhere('items.name', 'like', '%' .$search. '%');
                                        }])
                                        ->whereHas('item', function($q) use ($search) {
                                            $q->where('items.code', 'like', '%' .$search. '%')
                                            ->orWhere('items.name', 'like', '%' .$search. '%');
                                        })
                                        ->where('stock_mutation_id', $stock_mutation_id)
                                        ->where('quantity', 1)
                                        ->get();
        }

        $response = [];
        foreach($InboundMutationDetails as $InboundMutationDetail){
            $response['results'][] = [
                "id" => $InboundMutationDetail->coding,
                "text" => $InboundMutationDetail->item->code . ' | ' . 
                $InboundMutationDetail->serial_number . ' | ' .
                $InboundMutationDetail->item->name . ' | ' . 
                $InboundMutationDetail->alias_name
            ];
        }
        return response()->json($response);
    }
}
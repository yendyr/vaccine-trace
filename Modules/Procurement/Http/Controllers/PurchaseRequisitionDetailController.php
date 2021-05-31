<?php

namespace Modules\Procurement\Http\Controllers;

use Modules\Procurement\Entities\PurchaseRequisition;
use Modules\Procurement\Entities\PurchaseRequisitionDetail;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PurchaseRequisitionDetailController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        // $this->authorizeResource(AircraftConfiguration::class, 'configuration_detail');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $purchase_requisition_id = $request->id;
        $PurchaseRequisition = PurchaseRequisition::where('id', $purchase_requisition_id)->first();

        $approved = false;
        if ($PurchaseRequisition->approvals()->count() > 0) {
            $approved = true;
        }
        
        $data = PurchaseRequisitionDetail::where('purchase_requisition_id', $purchase_requisition_id)
                                ->with(['item.unit',
                                        'item_group:id,item_id,serial_number,alias_name,coding,parent_coding',
                                        'item_group.item']);
        
        return Datatables::of($data)
        // ->addColumn('highlighted', function($row){
        //     if ($row->highlight == 1){
        //         return '<label class="label label-primary">Yes</label>';
        //     } else{
        //         return '<label class="label label-danger">No</label>';
        //     }
        // })
        ->addColumn('parent', function($row){
            if ($row->item_group) {
                return 'P/N: <strong>' . $row->item_group->item->code . '</strong><br>' . 
                'Name: <strong>' . $row->item_group->item->name . '</strong><br>';
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
            if ($approved == false) {
                $noAuthorize = true;

                if(Auth::user()->can('update', PurchaseRequisition::class)) {
                    $updateable = 'button';
                    $updateValue = $row->id;
                    $noAuthorize = false;
                }
                if(Auth::user()->can('delete', PurchaseRequisition::class)) {
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
                return '<p class="text-muted font-italic">Already Approved</p>';
            }
        })
        ->escapeColumns([])
        ->make(true);
    }

    public function tree(Request $request)
    {
        $purchase_requisition_id = $request->id;
        $datas = PurchaseRequisitionDetail::where('purchase_requisition_id', $purchase_requisition_id)
                                ->with(['item.unit',
                                        'item_group:id,item_id,coding,parent_coding'])
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
                '</strong> | Item Name: <strong>' . $data->item->name . '</strong>'
            ];
        }
        return response()->json($response);
    }

    public function store(Request $request)
    {
        $PurchaseRequisition = PurchaseRequisition::where('id', $request->purchase_requisition_id)->first();

        if ($PurchaseRequisition->approvals()->count() == 0) {
            $request->validate([
                'item_id' => ['required'],
            ]);

            // if($request->quantity > 1) {
            //     $quantity = $request->quantity;
            //     $serial_number = null;
            // }
            // else {
            //     $quantity = 1;
            //     $serial_number = $request->serial_number;
            // }

            $parent_coding = null;
            
            if ($request->parent_coding) {
                $parent_coding = $request->parent_coding;
                // $parentRow = PurchaseRequisitionDetail::where('coding', $parent_coding)->first();
                // $detailed_item_location = $parentRow->detailed_item_location;
            }
            
            // if ($request->highlight) {
            //     $highlight = 1;
            // } 
            // else {
            //     $highlight = 0;
            // }
    
            DB::beginTransaction();
            $PurchaseRequisitionDetail = PurchaseRequisitionDetail::create([
                'uuid' =>  Str::uuid(),
    
                'purchase_requisition_id' => $request->purchase_requisition_id,
                'item_id' => $request->item_id,
                'request_quantity' => $request->quantity,
                'description' => $request->description,
                // 'detailed_item_location' => $detailed_item_location,
                'parent_coding' => $parent_coding,
    
                'owned_by' => $request->user()->company_id,
                'status' => 1,
                'created_by' => $request->user()->id,
            ]);
            $PurchaseRequisitionDetail->update([
                'coding' => $request->purchase_requisition_id . '-' . $PurchaseRequisitionDetail->id,
            ]);
            DB::commit();
    
            return response()->json(['success' => 'Item/Component Data has been Added']);
        }
        else {
            return response()->json(['error' => "This Purchase Requisition and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function update(Request $request, PurchaseRequisitionDetail $PurchaseRequisitionDetail)
    {
        $currentRow = PurchaseRequisitionDetail::where('id', $PurchaseRequisitionDetail->id)
                                        ->with('all_childs')
                                        ->first();

        $PurchaseRequisition = PurchaseRequisition::where('id', $currentRow->purchase_requisition_id)->first();

        if ($PurchaseRequisition->approvals()->count() == 0) {
            $request->validate([
                'item_id' => ['required'],
            ]);

            if($request->quantity > 1) {
                if (sizeof($currentRow->all_childs) > 0) {
                    return response()->json(['error' => "This Item/Component has Child(s) Item, You Can't Set Quantity Larger than 1"]);
                }
                else {
                    $quantity = $request->quantity;
                    // $serial_number = null;
                }
            }
            else {
                $quantity = 1;
                // $serial_number = $request->serial_number;
            }

            // if ($request->highlight) {
            //     $highlight = 1;
            // } 
            // else {
            //     $highlight = 0;
            // }
    
            $parent_coding = null;
            
            if ($request->parent_coding) {
                if (Self::isValidParent($currentRow, $request->parent_coding)) {
                    if ($request->parent_coding != $currentRow->coding) {
                        $parent_coding = $request->parent_coding;
                        // $parentRow = PurchaseRequisitionDetail::where('coding', $parent_coding)->first();
                        // $detailed_item_location = $parentRow->detailed_item_location;
                    }
                }
                else {
                    return response()->json(['error' => "The Choosen Parent is Already in Child of this Item"]);
                }
            }
    
            DB::beginTransaction();
            $currentRow->update([
                'item_id' => $request->item_id,
                'request_quantity' => $request->quantity,
                'description' => $request->description,
                'parent_coding' => $parent_coding,

                'updated_by' => Auth::user()->id,
            ]);
            // if (sizeof($currentRow->all_childs) > 0) {
            //     Self::updateChilds($currentRow, $detailed_item_location);
            // }
            
            DB::commit();
            
            return response()->json(['success' => 'Item/Component Data has been Updated']);
        }
        else {
            return response()->json(['error' => "This Purchase Requisition and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    // public static function updateChilds($currentRow, $detailed_item_location)
    // {
    //     foreach($currentRow->all_childs as $childRow) {
    //         $childRow->update([
    //             'detailed_item_location' => $detailed_item_location,
    //             'updated_by' => Auth::user()->id,
    //         ]);
    //         if (sizeof($childRow->all_childs) > 0) {
    //             Self::updateChilds($childRow, $detailed_item_location);
    //         }
    //     }
    // }

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

    public function destroy(PurchaseRequisitionDetail $PurchaseRequisitionDetail)
    {
        $currentRow = PurchaseRequisitionDetail::where('id', $PurchaseRequisitionDetail->id)
                                        ->with(['all_childs'])
                                        ->first();

        $PurchaseRequisition = PurchaseRequisition::where('id', $currentRow->purchase_requisition_id)->first();

        if ($PurchaseRequisition->approvals()->count() == 0) {
            if (sizeof($currentRow->all_childs) > 0) {
                return response()->json(['error' => "This Item/Component has Child(s) Item, You Can't Directly Delete this Item/Component"]);
            }
            else {
                $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);
                PurchaseRequisitionDetail::destroy($PurchaseRequisitionDetail->id);
                return response()->json(['success' => 'Item/Component Data has been Deleted']);
            }
        }
        else {
            return response()->json(['error' => "This Purchase Requisition and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function select2Parent(Request $request)
    {
        $search = $request->term;
        $purchase_requisition_id = $request->purchase_requisition_id;

        if($search != '') {
            $PurchaseRequisitionDetails = PurchaseRequisitionDetail::with(['item' => function($q) use ($search) {
                                            $q->where('items.code', 'like', '%' .$search. '%')
                                            ->orWhere('items.name', 'like', '%' .$search. '%');
                                        }])
                                        ->whereHas('item', function($q) use ($search) {
                                            $q->where('items.code', 'like', '%' .$search. '%')
                                            ->orWhere('items.name', 'like', '%' .$search. '%');
                                        })
                                        ->where('purchase_requisition_id', $purchase_requisition_id)
                                        ->where('request_quantity', 1)
                                        ->get();
        }

        $response = [];
        foreach($PurchaseRequisitionDetails as $PurchaseRequisitionDetail){
            $response['results'][] = [
                "id" => $PurchaseRequisitionDetail->coding,
                "text" => $PurchaseRequisitionDetail->item->code . ' | ' . 
                $PurchaseRequisitionDetail->item->name
            ];
        }
        return response()->json($response);
    }
}
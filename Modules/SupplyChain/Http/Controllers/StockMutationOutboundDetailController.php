<?php

namespace Modules\SupplyChain\Http\Controllers;

use Modules\SupplyChain\Entities\StockMutation;
use Modules\SupplyChain\Entities\OutboundMutationDetail;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\SupplyChain\Entities\ItemStock;
use Yajra\DataTables\Facades\DataTables;

class StockMutationOutboundDetailController extends Controller
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
        
        $data = OutboundMutationDetail::where('stock_mutation_id', $stock_mutation_id)
                                ->with(['item_stock.item.unit',
                                        'item_stock.item_stock_initial_aging',
                                        'item_stock.item_group:id,item_id,alias_name,coding,parent_coding'])
                                ->orderBy('created_at','desc');
                                                
        if ($StockMutation->approvals()->count() == 0) {
            return Datatables::of($data)
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
            ->addColumn('creator_name', function($row){
                return $row->creator->name ?? '-';
            })
            ->addColumn('updater_name', function($row){
                return $row->updater->name ?? '-';
            })
            ->addColumn('action', function($row) {
                if ($row->item_stock->parent_coding) {
                    return "<span class='text-muted font-italic'>this Item has Parent</span>";
                }
                else {
                    $noAuthorize = true;

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

                    if ($noAuthorize == false) {
                        return view('components.action-button', compact(['updateable', 'updateValue','deleteable', 'deleteId']));
                    }
                    else {
                        return '<p class="text-muted font-italic">Not Authorized</p>';
                    }
                }
            })
            ->escapeColumns([])
            ->make(true);
        }
        else {
            return Datatables::of($data)
            ->addColumn('parent_item_code', function($row){
                return $row->item_stock->item_group->item->code ?? '-';
            })
            ->addColumn('parent_item_name', function($row){
                if ($row->item_stock->item_group) {
                    return $row->item_stock->item_group->item->name . ' | ' . $row->item_stock->item_group->alias_name;
                }
                else {
                    return '-';
                }
            })
            ->addColumn('creator_name', function($row){
                return $row->creator->name ?? '-';
            })
            ->addColumn('updater_name', function($row){
                return $row->updater->name ?? '-';
            })
            ->addColumn('action', function($row) {
                return '<p class="text-muted font-italic">Already Approved</p>';
            })
            ->escapeColumns([])
            ->make(true);
        }
    }

    public function tree(Request $request)
    {
        $stock_mutation_id = $request->id;
        $datas = OutboundMutationDetail::where('stock_mutation_id', $stock_mutation_id)
                                ->with(['item_stock.item.unit',
                                        'item_stock.item_stock_initial_aging',
                                        'item_stock.item_group:id,item_id,alias_name,coding,parent_coding'])
                                ->orderBy('created_at','desc')
                                ->get();

        $response = [];
        foreach($datas as $data) {
            if ($data->item_stock->parent_coding) {
                $parent = $data->item_stock->parent_coding;
            }
            else {
                $parent = '#';
            }

            $response[] = [
                "id" => $data->item_stock->coding,
                "parent" => $parent,
                "text" => 'P/N: <strong>' . $data->item_stock->item->code . '</strong> | Item Name: <strong>' . $data->item_stock->item->name . '</strong> | Alias Name: <strong>' . $data->item_stock->alias_name . '</strong>'
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
    
                'owned_by' => $request->user()->company_id,
                'status' => 1,
                'created_by' => $request->user()->id,
            ]);
            $item_stock->update([
                'reserved_quantity' => $item_stock->reserved_quantity + $outbound_quantity,
            ]);
            if (sizeof($item_stock->all_childs) > 0) {
                Self::pickChilds($item_stock, $request->stock_mutation_id);
            }
            DB::commit();
    
            return response()->json(['success' => 'Outbound Item/Component Data has been Added']);
        }
        else {
            return response()->json(['error' => "This Stock Mutation Outbound and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    // public function update(Request $request, StockMutationDetail $MutationInboundDetail)
    // {
    //     $currentRow = StockMutationDetail::where('id', $MutationInboundDetail->id)
    //                                     ->with('all_childs')
    //                                     ->first();

    //     $StockMutation = StockMutation::where('id', $currentRow->stock_mutation_id)->first();

    //     if ($StockMutation->approvals()->count() == 0) {
    //         $request->validate([
    //             'item_id' => ['required'],
    //         ]);

    //         if($request->quantity > 1) {
    //             $quantity = $request->quantity;
    //             $serial_number = null;
    //         }
    //         else {
    //             $quantity = 1;
    //             $serial_number = $request->serial_number;
    //         }
    
    //         // if ($request->status) {
    //         //     $status = 1; 
                
    //         //     if ($currentRow->parent_coding != null) {
    //         //         if ($currentRow->item_group->status == 0) {
    //         //             return response()->json(['error' => "This Item's Parent Status Still Deactivated, so You Can't Activate this Item"]);
    //         //         }
    //         //     }
    //         // } 
    //         // else {
    //         //     $status = 0;
    //         // }
    
    //         if ($request->highlight) {
    //             $highlight = 1;
    //         } 
    //         else {
    //             $highlight = 0;
    //         }
    
    //         $initial_start_date = $request->initial_start_date;
    //         $expired_date = $request->expired_date;
            
    //         if (Self::isValidParent($currentRow, $request->parent_coding)) {
    //             if ($request->parent_coding == $currentRow->coding) {
    //                 $parent_coding = null;
    //             }
    //             else {
    //                 $parent_coding = $request->parent_coding;
    //             }
    //         }
    //         else {
    //             return response()->json(['error' => "The Choosen Parent is Already in Child of this Item"]);
    //         }
    
    //         DB::beginTransaction();
    //         $currentRow
    //             ->update([
    //                 'item_id' => $request->item_id,
    //                 'alias_name' => $request->alias_name,
    //                 'quantity' => $quantity,
    //                 'serial_number' => $serial_number,
    //                 'highlight' => $highlight,
    //                 'description' => $request->description,
    //                 'detailed_item_location' => $request->detailed_item_location,
    //                 'parent_coding' => $parent_coding,
    
    //                 'updated_by' => Auth::user()->id,
    //         ]);
    //         // if (sizeof($currentRow->all_childs) > 0) {
    //         //     Self::updateChilds($currentRow, $status);
    //         // }
    //         $currentRow->mutation_detail_initial_aging()
    //             ->update([
    //                 'uuid' => Str::uuid(),

    //                 'initial_flight_hour' => $request->initial_flight_hour,
    //                 'initial_block_hour' => $request->initial_block_hour,
    //                 'initial_flight_cycle' => $request->initial_flight_cycle,
    //                 'initial_flight_event' => $request->initial_flight_event,
    //                 'initial_start_date' => $initial_start_date,
    //                 'expired_date' => $expired_date,
                    
    //                 'updated_by' => $request->user()->id,
    //             ]);
    //         DB::commit();
            
    //         return response()->json(['success' => 'Item/Component Data has been Updated']);
    //     }
    //     else {
    //         return response()->json(['error' => "This Stock Mutation Inbound and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
    //     }
    // }

    public static function pickChilds($currentRow, $stock_mutation_id)
    {
        foreach($currentRow->all_childs as $childRow) {
            OutboundMutationDetail::create([
                'uuid' =>  Str::uuid(),
    
                'stock_mutation_id' => $stock_mutation_id,
                'item_stock_id' => $childRow->id,
                'outbound_quantity' => $childRow->quantity,
    
                'owned_by' => Auth::user()->company_id,
                'status' => 1,
                'created_by' => Auth::user()->id,
            ]);
            $childRow->update([
                'reserved_quantity' => $childRow->quantity,
            ]);
            if (sizeof($childRow->all_childs) > 0) {
                Self::pickChilds($childRow, $stock_mutation_id);
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

    public function destroy(OutboundMutationDetail $MutationOutboundDetail)
    {
        $currentRow = OutboundMutationDetail::where('id', $MutationOutboundDetail->id)
                                        ->with(['item_stock.all_childs'])
                                        ->first();

        $StockMutation = StockMutation::where('id', $currentRow->stock_mutation_id)->first();

        if ($StockMutation->approvals()->count() == 0) {
        //     if (sizeof($currentRow->all_childs) > 0) {
        //         return response()->json(['error' => "This Item/Component has Child(s) Item, You Can't Directly Delete this Item/Component"]);
        //     }
        //     else {
        //         $currentRow
        //         ->update([
        //             'deleted_by' => Auth::user()->id,
        //         ]);
        //         StockMutationDetail::destroy($MutationInboundDetail->id);
        //         return response()->json(['success' => 'Item/Component Data has been Deleted']);
        //     }
            $item_stock = ItemStock::where('id', $currentRow->item_stock_id)->first();

            DB::beginTransaction();
            $currentRow->update([
                'deleted_by' => Auth::user()->id,
            ]);
            OutboundMutationDetail::destroy($MutationOutboundDetail->id);
            $item_stock->update([
                'reserved_quantity' => $item_stock->reserved_quantity - $currentRow->outbound_quantity,
            ]);
            DB::commit();

            return response()->json(['success' => 'Outbound Item/Component Data has been Deleted']);
        }
        else {
            return response()->json(['error' => "This Stock Mutation Outbound and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function select2Parent(Request $request)
    {
        // $search = $request->term;
        // $stock_mutation_id = $request->stock_mutation_id;

        // if($search != '') {
        //     $StockMutationDetails = StockMutationDetail::with(['item' => function($q) use ($search) {
        //                                     $q->where('items.code', 'like', '%' .$search. '%')
        //                                     ->orWhere('items.name', 'like', '%' .$search. '%');
        //                                 }])
        //                                 ->whereHas('item', function($q) use ($search) {
        //                                     $q->where('items.code', 'like', '%' .$search. '%')
        //                                     ->orWhere('items.name', 'like', '%' .$search. '%');
        //                                 })
        //                                 ->where('stock_mutation_id', $stock_mutation_id)
        //                                 ->get();
        // }

        // $response = [];
        // foreach($StockMutationDetails as $StockMutationDetail){
        //     $response['results'][] = [
        //         "id" => $StockMutationDetail->coding,
        //         "text" => $StockMutationDetail->item->code . ' | ' . 
        //         $StockMutationDetail->item->name . ' | ' . 
        //         $StockMutationDetail->alias_name
        //     ];
        // }
        // return response()->json($response);
    }
}
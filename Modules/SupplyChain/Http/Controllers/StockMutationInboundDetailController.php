<?php

namespace Modules\SupplyChain\Http\Controllers;

use Modules\SupplyChain\Entities\StockMutation;
use Modules\SupplyChain\Entities\StockMutationDetail;
use Modules\SupplyChain\Entities\StockMutationDetailInitialAging;

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
        
        $data = StockMutationDetail::where('stock_mutation_id', $stock_mutation_id)
                                ->with(['item.unit',
                                        'mutation_detail_initial_aging',
                                        'item_group:id,item_id,serial_number,alias_name,coding,parent_coding',
                                        'item_group.item'])
                                ->orderBy('created_at','desc');
                                                
        
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
        ->addColumn('creator_name', function($row){
            return $row->creator->name ?? '-';
        })
        ->addColumn('updater_name', function($row){
            return $row->updater->name ?? '-';
        })
        ->addColumn('action', function($row) use ($approved) {
            if ($approved == false) {
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
            else {
                return '<p class="text-muted font-italic">Already Approved</p>';
            }
        })
        ->escapeColumns([])
        ->make(true);
    }

    public function tree(Request $request)
    {
        $stock_mutation_id = $request->id;
        $datas = StockMutationDetail::where('stock_mutation_id', $stock_mutation_id)
                                ->with(['item:id,code,name',
                                        'item_group:id,item_id,alias_name,coding,parent_coding'])
                                ->orderBy('created_at','desc')
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
                "text" => 'P/N: <strong>' . $data->item->code . '</strong> | Item Name: <strong>' . $data->item->name . '</strong> | Alias Name: <strong>' . $data->alias_name . '</strong>'
            ];
        }
        return response()->json($response);
    }

    public function store(Request $request)
    {
        $StockMutation = StockMutation::where('id', $request->stock_mutation_id)->first();

        if ($StockMutation->approvals()->count() == 0) {
            $request->validate([
                'item_id' => ['required'],
            ]);

            if($request->quantity > 1) {
                $quantity = $request->quantity;
                $serial_number = null;
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
    
            $initial_start_date = $request->initial_start_date;
            $expired_date = $request->expired_date;
    
            DB::beginTransaction();
            $StockMutationDetail = StockMutationDetail::create([
                'uuid' =>  Str::uuid(),
    
                'stock_mutation_id' => $request->stock_mutation_id,
                'item_id' => $request->item_id,
                'quantity' => $quantity,
                'serial_number' => $serial_number,
                'alias_name' => $request->alias_name,
                'highlight' => $highlight,
                'description' => $request->description,
                'detailed_item_location' => $request->detailed_item_location,
                'parent_coding' => $request->parent_coding,
    
                'owned_by' => $request->user()->company_id,
                'status' => 1,
                'created_by' => $request->user()->id,
            ]);
            $StockMutationDetail->update([
                'coding' => $StockMutation->warehouse_destination . '-' . $StockMutationDetail->id,
            ]);
            $StockMutationDetail->mutation_detail_initial_aging()
                ->save(new StockMutationDetailInitialAging([
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
                ]));
            DB::commit();
    
            return response()->json(['success' => 'Item/Component Data has been Added']);
        }
        else {
            return response()->json(['error' => "This Stock Mutation Inbound and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function update(Request $request, StockMutationDetail $MutationInboundDetail)
    {
        $currentRow = StockMutationDetail::where('id', $MutationInboundDetail->id)
                                        ->with('all_childs')
                                        ->first();

        $StockMutation = StockMutation::where('id', $currentRow->stock_mutation_id)->first();

        if ($StockMutation->approvals()->count() == 0) {
            $request->validate([
                'item_id' => ['required'],
            ]);

            if($request->quantity > 1) {
                $quantity = $request->quantity;
                $serial_number = null;
            }
            else {
                $quantity = 1;
                $serial_number = $request->serial_number;
            }
    
            // if ($request->status) {
            //     $status = 1; 
                
            //     if ($currentRow->parent_coding != null) {
            //         if ($currentRow->item_group->status == 0) {
            //             return response()->json(['error' => "This Item's Parent Status Still Deactivated, so You Can't Activate this Item"]);
            //         }
            //     }
            // } 
            // else {
            //     $status = 0;
            // }
    
            if ($request->highlight) {
                $highlight = 1;
            } 
            else {
                $highlight = 0;
            }
    
            $initial_start_date = $request->initial_start_date;
            $expired_date = $request->expired_date;
            
            if (Self::isValidParent($currentRow, $request->parent_coding)) {
                if ($request->parent_coding == $currentRow->coding) {
                    $parent_coding = null;
                }
                else {
                    $parent_coding = $request->parent_coding;
                }
            }
            else {
                return response()->json(['error' => "The Choosen Parent is Already in Child of this Item"]);
            }
    
            DB::beginTransaction();
            $currentRow
                ->update([
                    'item_id' => $request->item_id,
                    'alias_name' => $request->alias_name,
                    'quantity' => $quantity,
                    'serial_number' => $serial_number,
                    'highlight' => $highlight,
                    'description' => $request->description,
                    'detailed_item_location' => $request->detailed_item_location,
                    'parent_coding' => $parent_coding,
    
                    'updated_by' => Auth::user()->id,
            ]);
            // if (sizeof($currentRow->all_childs) > 0) {
            //     Self::updateChilds($currentRow, $status);
            // }
            $currentRow->mutation_detail_initial_aging()
                ->update([
                    'uuid' => Str::uuid(),

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

    // public static function updateChilds($currentRow, $status)
    // {
    //     foreach($currentRow->all_childs as $childRow) {
    //         $childRow
    //             ->update([
    //                 'status' => $status,
    //                 'updated_by' => Auth::user()->id,
    //             ]);
    //         if (sizeof($childRow->all_childs) > 0) {
    //             Self::updateChilds($childRow, $status);
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

    public function destroy(StockMutationDetail $MutationInboundDetail)
    {
        $currentRow = StockMutationDetail::where('id', $MutationInboundDetail->id)
                                        ->with(['all_childs'])
                                        ->first();

        $StockMutation = StockMutation::where('id', $currentRow->stock_mutation_id)->first();

        if ($StockMutation->approvals()->count() == 0) {
            if (sizeof($currentRow->all_childs) > 0) {
                return response()->json(['error' => "This Item/Component has Child(s) Item, You Can't Directly Delete this Item/Component"]);
            }
            else {
                $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);
                StockMutationDetail::destroy($MutationInboundDetail->id);
                return response()->json(['success' => 'Item/Component Data has been Deleted']);
            }
        }
        else {
            return response()->json(['error' => "This Stock Mutation Inbound and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function select2Parent(Request $request)
    {
        $search = $request->term;
        $stock_mutation_id = $request->stock_mutation_id;

        if($search != '') {
            $StockMutationDetails = StockMutationDetail::with(['item' => function($q) use ($search) {
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
        foreach($StockMutationDetails as $StockMutationDetail){
            $response['results'][] = [
                "id" => $StockMutationDetail->coding,
                "text" => $StockMutationDetail->item->code . ' | ' . 
                $StockMutationDetail->serial_number . ' | ' .
                $StockMutationDetail->item->name . ' | ' . 
                $StockMutationDetail->alias_name
            ];
        }
        return response()->json($response);
    }
}
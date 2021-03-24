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

        $approved = false;
        if ($StockMutation->approvals()->count() > 0) {
            $approved = true;
        }
        
        $data = OutboundMutationDetail::where('stock_mutation_id', $stock_mutation_id)
                                ->with(['item_stock.item.unit',
                                        'item_stock.item_stock_initial_aging',
                                        'item_stock.item_group:id,item_id,serial_number,alias_name,coding,parent_coding'])
                                ->orderBy('created_at','desc');
        
        return Datatables::of($data)
        ->addColumn('parent', function($row){
            if ($row->item_stock->item_group) {
                return 'P/N: <strong>' . $row->item_stock->item_group->item->code . '</strong><br>' . 
                'S/N: <strong>' . $row->item_stock->item_group->serial_number . '</strong><br>' .
                'Name: <strong>' . $row->item_stock->item_group->item->name . '</strong><br>' .
                'Alias: <strong>' . $row->item_stock->item_group->alias_name . '</strong><br>';
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
            if ($row->item_stock->parent_coding) {
                return "<span class='text-info font-italic'>this Item Included with its Parent</span>";
            }
            else if ($approved == false) {
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
            else if ($approved == true) {
                return '<p class="text-muted font-italic">Already Approved</p>';
            }
        })
        ->escapeColumns([])
        ->make(true);
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
                'description' => $request->outbound_remark,
    
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

    public function update(Request $request, OutboundMutationDetail $MutationOutboundDetail)
    {
        $currentRow = OutboundMutationDetail::where('id', $MutationOutboundDetail->id)
                                        ->with('all_childs')
                                        ->first();

        $StockMutation = StockMutation::where('id', $currentRow->stock_mutation_id)->first();

        if ($StockMutation->approvals()->count() == 0) {
            $request->validate([
                'stock_mutation_id' => ['required'],
                'item_stock_id' => ['required'],
                'outbound_quantity' => ['required'],
            ]);

            $item_stock = ItemStock::where('id', $request->item_stock_id)->first();
            
            if(($request->outbound_quantity > 0) && ($request->outbound_quantity < ($request->available_quantity + 1))) {
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
            ]);
            DB::commit();
            
            return response()->json(['success' => 'Item/Component Data has been Updated']);
        }
        else {
            return response()->json(['error' => "This Stock Mutation Outbound and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public static function pickChilds($itemStockRow, $stock_mutation_id)
    {
        foreach($itemStockRow->all_childs as $childRow) {
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

    public static function unpickChilds($itemStockRow, $stock_mutation_id)
    {
        foreach($itemStockRow->all_childs as $childRow) {
            $childRow->update([
                'reserved_quantity' => 0,
            ]);

            $outboundDetailRow = OutboundMutationDetail::where('stock_mutation_id', $stock_mutation_id)
                                    ->where('item_stock_id', $childRow->id)
                                    ->first();
            // dd($outboundDetailRow);
            $outboundDetailRow->update([
                'deleted_by' => Auth::user()->id,
            ]);
            OutboundMutationDetail::destroy($outboundDetailRow->id);
            
            if (sizeof($childRow->all_childs) > 0) {
                Self::unpickChilds($childRow, $stock_mutation_id);
            }
        }
    }

    public function destroy(OutboundMutationDetail $MutationOutboundDetail)
    {
        $mutationOutboundDetailRow = OutboundMutationDetail::where('id', $MutationOutboundDetail->id)
                                        ->with(['item_stock.all_childs'])
                                        ->first();

        $StockMutation = StockMutation::where('id', $mutationOutboundDetailRow->stock_mutation_id)
                                    ->first();

        if ($StockMutation->approvals()->count() == 0) {
            $item_stock = ItemStock::where('id', $mutationOutboundDetailRow->item_stock_id)->first();

            DB::beginTransaction();
            if (sizeof($item_stock->all_childs) > 0) {
                Self::unpickChilds($item_stock, $mutationOutboundDetailRow->stock_mutation_id);
            }
            $mutationOutboundDetailRow->update([
                'deleted_by' => Auth::user()->id,
            ]);
            OutboundMutationDetail::destroy($MutationOutboundDetail->id);
            $item_stock->update([
                'reserved_quantity' => $item_stock->reserved_quantity - $mutationOutboundDetailRow->outbound_quantity,
            ]);
            DB::commit();

            return response()->json(['success' => 'Outbound Item/Component Data has been Deleted']);
        }
        else {
            return response()->json(['error' => "This Stock Mutation Outbound and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }
}
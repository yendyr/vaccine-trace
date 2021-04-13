<?php

namespace Modules\SupplyChain\Http\Controllers;

use Modules\SupplyChain\Entities\StockMutation;
use Modules\SupplyChain\Entities\TransferMutationDetail;
use Modules\SupplyChain\Entities\ItemStock;

use app\Helpers\SupplyChain\ItemStockMutation;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Yajra\DataTables\Facades\DataTables;

class StockMutationTransferDetailController extends Controller
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
        
        $data = TransferMutationDetail::where('stock_mutation_id', $stock_mutation_id)
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
        $datas = TransferMutationDetail::where('stock_mutation_id', $stock_mutation_id)
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

            if ($data->item_stock->alias_name) {
                $alias = $data->item_stock->alias_name;
            }
            else {
                $alias = '-';
            }

            $response[] = [
                "id" => $data->item_stock->coding,
                "parent" => $parent,
                "text" => 'P/N: <strong>' . $data->item_stock->item->code . 
                '</strong> | Item Name: <strong>' . $data->item_stock->item->name . 
                '</strong> | Alias Name: <strong>' . $alias . 
                '</strong> | Transfer Qty: <strong>' . $data->transfer_quantity . ' ' .
                $data->item_stock->item->unit->name
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
                'transfer_quantity' => ['required'],
            ]);

            $item_stock = ItemStock::where('id', $request->item_stock_id)->first();
            
            if(($request->transfer_quantity > 0) && ($request->transfer_quantity <= $item_stock->available_quantity)) {
                // this IF means: transfer/move ALL item stock to other warehouse
                if($request->transfer_quantity == $item_stock->quantity) {
                    $transfer_quantity = $request->transfer_quantity;
                }

                // this ELSE means: transfer/move partial item stock to other warehouse
                else {
                    return response()->json(['error' => "WIP"]);
                }
            }
            else {
                return response()->json(['error' => "Transfer Quantity Must be Greater than 0 and Less than Current Available Stock"]);
            }
    
            DB::beginTransaction();
            TransferMutationDetail::create([
                'uuid' =>  Str::uuid(),
    
                'stock_mutation_id' => $request->stock_mutation_id,
                'item_stock_id' => $request->item_stock_id,
                'transfer_quantity' => $transfer_quantity,
                'description' => $request->transfer_remark,
    
                'owned_by' => $request->user()->company_id,
                'status' => 1,
                'created_by' => $request->user()->id,
            ]);
            $item_stock->update([
                'reserved_quantity' => $item_stock->reserved_quantity + $transfer_quantity,

                'updated_by' => Auth::user()->id,
            ]);
            if (sizeof($item_stock->all_childs) > 0) {
                ItemStockMutation::pickChildsForTransfer($item_stock, $request->stock_mutation_id);
            }
            DB::commit();
    
            return response()->json(['success' => 'Transfer Item/Component Data has been Added']);
        }
        else {
            return response()->json(['error' => "This Stock Mutation Transfer and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function update(Request $request, TransferMutationDetail $MutationTransferDetail)
    {
        $currentRow = TransferMutationDetail::where('id', $MutationTransferDetail->id)
                                        ->first();

        $StockMutation = StockMutation::where('id', $currentRow->stock_mutation_id)->first();

        if ($StockMutation->approvals()->count() == 0) {
            $request->validate([
                'stock_mutation_id' => ['required'],
                'item_stock_id' => ['required'],
                'transfer_quantity' => ['required'],
            ]);

            $item_stock = ItemStock::where('id', $request->item_stock_id)->first();

            $temporary_available_quantity = $item_stock->available_quantity + $currentRow->transfer_quantity;
        
            if(($request->transfer_quantity > 0) && ($request->transfer_quantity <= $temporary_available_quantity)) {
                // this IF means: transfer/move ALL item stock to other warehouse
                if($request->transfer_quantity == $item_stock->quantity) {
                    $transfer_quantity = $request->transfer_quantity;
                }

                // this ELSE means: transfer/move partial item stock to other warehouse
                else {
                    return response()->json(['error' => "WIP"]);
                }
            }
            else {
                return response()->json(['error' => "Transfer Quantity Must be Greater than 0 and Less than Current Available Stock"]);
            }

            $transfer_quantity_gap = $transfer_quantity - $currentRow->transfer_quantity;
    
            DB::beginTransaction();
            $currentRow->update([
                'transfer_quantity' => $transfer_quantity,
                'description' => $request->transfer_remark,

                'updated_by' => Auth::user()->id,
            ]);
            $item_stock->update([
                'reserved_quantity' => $item_stock->reserved_quantity + $transfer_quantity_gap,

                'updated_by' => Auth::user()->id,
            ]);
            DB::commit();
            
            return response()->json(['success' => 'Item/Component Data has been Updated']);
        }
        else {
            return response()->json(['error' => "This Stock Mutation Transfer and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function destroy(TransferMutationDetail $MutationTransferDetail)
    {
        $StockMutation = StockMutation::where('id', $MutationTransferDetail->stock_mutation_id)
                                    ->first();

        if ($StockMutation->approvals()->count() == 0) {
            ItemStockMutation::deleteTransferDetailRow($MutationTransferDetail);
            return response()->json(['success' => 'Transfer Item/Component Data has been Deleted']);
        }
        else {
            return response()->json(['error' => "This Stock Mutation Transfer and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }
}
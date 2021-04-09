<?php

namespace app\Helpers\SupplyChain;

use Modules\SupplyChain\Entities\ItemStock;
use Modules\SupplyChain\Entities\StockMutation;
use Modules\SupplyChain\Entities\StockMutationApproval;
use Modules\SupplyChain\Entities\OutboundMutationDetail;
use Modules\SupplyChain\Entities\TransferMutationDetail;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemStockMutation
{
    public static function pickChildsForOutbound($itemStockRow, $stock_mutation_id)
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

                'updated_by' => Auth::user()->id,
            ]);
            if (sizeof($childRow->all_childs) > 0) {
                Self::pickChildsForOutbound($childRow, $stock_mutation_id);
            }
        }
    }

    public static function unpickChildsForOutbound($itemStockRow, $stock_mutation_id)
    {
        foreach($itemStockRow->all_childs as $childRow) {
            $childRow->update([
                'reserved_quantity' => 0,

                'updated_by' => Auth::user()->id,
            ]);

            $outboundDetailRow = OutboundMutationDetail::where('stock_mutation_id', $stock_mutation_id)
                                    ->where('item_stock_id', $childRow->id)
                                    ->first();
            $outboundDetailRow->update([
                'deleted_by' => Auth::user()->id,
            ]);
            OutboundMutationDetail::destroy($outboundDetailRow->id);
            
            if (sizeof($childRow->all_childs) > 0) {
                Self::unpickChildsForOutbound($childRow, $stock_mutation_id);
            }
        }
    }

    public static function deleteOutboundDetailRow($outboundDetailRow)
    {
        $mutationOutboundDetailRow = OutboundMutationDetail::where('id', $outboundDetailRow->id)
                                                    ->with(['item_stock.all_childs'])
                                                    ->first();

        $item_stock = ItemStock::where('id', $mutationOutboundDetailRow->item_stock_id)->first();

        DB::beginTransaction();
        if (sizeof($item_stock->all_childs) > 0) {
            Self::unpickChildsForOutbound($item_stock, $mutationOutboundDetailRow->stock_mutation_id);
        }
        $mutationOutboundDetailRow->update([
            'deleted_by' => Auth::user()->id,
        ]);
        OutboundMutationDetail::destroy($outboundDetailRow->id);
        $item_stock->update([
            'reserved_quantity' => $item_stock->reserved_quantity - $mutationOutboundDetailRow->outbound_quantity,

            'updated_by' => Auth::user()->id,
        ]);
        DB::commit();
    }

    public static function deleteOutbound($stockMutationRow)
    {
        $currentRow = StockMutation::where('id', $stockMutationRow->id)->first();

        DB::beginTransaction();
        foreach($currentRow->outbound_mutation_details as $outbound_mutation_detail) {
            $item_stock = ItemStock::where('id', $outbound_mutation_detail->item_stock_id)->first();

            $outbound_mutation_detail->update([
                'deleted_by' => Auth::user()->id,
            ]);
            OutboundMutationDetail::destroy($outbound_mutation_detail->id);
            $item_stock->update([
                'reserved_quantity' => $item_stock->reserved_quantity - $outbound_mutation_detail->outbound_quantity,

                'updated_by' => Auth::user()->id,
            ]);
        }

        $currentRow->update([
            'deleted_by' => Auth::user()->id,
        ]);

        StockMutation::destroy($stockMutationRow->id);
        DB::commit();
    }

    public static function approveOutbound($request, $stockMutationRow)
    {
        DB::beginTransaction();
        StockMutationApproval::create([
            'uuid' =>  Str::uuid(),

            'stock_mutation_id' =>  $stockMutationRow->id,
            'approval_notes' =>  $request->approval_notes,
    
            'owned_by' => $request->user()->company_id,
            'status' => 1,
            'created_by' => Auth::user()->id,
        ]);

        foreach($stockMutationRow->outbound_mutation_details as $outbound_mutation_detail) {
            $item_stock = ItemStock::where('id', $outbound_mutation_detail->item_stock_id)->first();

            $item_stock->update([
                'used_quantity' => $item_stock->used_quantity + $outbound_mutation_detail->outbound_quantity,
                'reserved_quantity' => $item_stock->reserved_quantity - $outbound_mutation_detail->outbound_quantity,

                'updated_by' => Auth::user()->id,
            ]);
        }
        DB::commit();
    }

    public static function pickChildsForTransfer($itemStockRow, $stock_mutation_id)
    {
        foreach($itemStockRow->all_childs as $childRow) {
            TransferMutationDetail::create([
                'uuid' =>  Str::uuid(),
    
                'stock_mutation_id' => $stock_mutation_id,
                'item_stock_id' => $childRow->id,
                'transfer_quantity' => $childRow->quantity,
    
                'owned_by' => Auth::user()->company_id,
                'status' => 1,
                'created_by' => Auth::user()->id,
            ]);
            $childRow->update([
                'reserved_quantity' => $childRow->quantity,

                'updated_by' => Auth::user()->id,
            ]);
            if (sizeof($childRow->all_childs) > 0) {
                Self::pickChildsForTransfer($childRow, $stock_mutation_id);
            }
        }
    }

    public static function unpickChildsForTransfer($itemStockRow, $stock_mutation_id)
    {
        foreach($itemStockRow->all_childs as $childRow) {
            $childRow->update([
                'reserved_quantity' => 0,

                'updated_by' => Auth::user()->id,
            ]);

            $transferDetailRow = TransferMutationDetail::where('stock_mutation_id', $stock_mutation_id)
                                    ->where('item_stock_id', $childRow->id)
                                    ->first();
            $transferDetailRow->update([
                'deleted_by' => Auth::user()->id,
            ]);
            TransferMutationDetail::destroy($transferDetailRow->id);
            
            if (sizeof($childRow->all_childs) > 0) {
                Self::unpickChildsForTransfer($childRow, $stock_mutation_id);
            }
        }
    }

    public static function deleteTransferDetailRow($transferDetailRow)
    {
        $mutationTransferDetailRow = TransferMutationDetail::where('id', $transferDetailRow->id)
                                                    ->with(['item_stock.all_childs'])
                                                    ->first();

        $item_stock = ItemStock::where('id', $mutationTransferDetailRow->item_stock_id)->first();

        DB::beginTransaction();
        if (sizeof($item_stock->all_childs) > 0) {
            Self::unpickChildsForTransfer($item_stock, $mutationTransferDetailRow->stock_mutation_id);
        }
        $mutationTransferDetailRow->update([
            'deleted_by' => Auth::user()->id,
        ]);
        TransferMutationDetail::destroy($transferDetailRow->id);
        $item_stock->update([
            'reserved_quantity' => $item_stock->reserved_quantity - $mutationTransferDetailRow->transfer_quantity,

            'updated_by' => Auth::user()->id,
        ]);
        DB::commit();
    }

    public static function deleteTransfer($stockMutationRow)
    {
        $currentRow = StockMutation::where('id', $stockMutationRow->id)->first();

        DB::beginTransaction();
        foreach($currentRow->transfer_mutation_details as $transfer_mutation_detail) {
            $item_stock = ItemStock::where('id', $transfer_mutation_detail->item_stock_id)->first();

            $transfer_mutation_detail->update([
                'deleted_by' => Auth::user()->id,
            ]);
            TransferMutationDetail::destroy($transfer_mutation_detail->id);
            $item_stock->update([
                'reserved_quantity' => $item_stock->reserved_quantity - $transfer_mutation_detail->transfer_quantity,

                'updated_by' => Auth::user()->id,
            ]);
        }

        $currentRow->update([
            'deleted_by' => Auth::user()->id,
        ]);

        StockMutation::destroy($stockMutationRow->id);
        DB::commit();
    }

    public static function approveTransfer($request, $stockMutationRow)
    {
        DB::beginTransaction();
        StockMutationApproval::create([
            'uuid' =>  Str::uuid(),

            'stock_mutation_id' =>  $stockMutationRow->id,
            'approval_notes' =>  $request->approval_notes,
    
            'owned_by' => $request->user()->company_id,
            'status' => 1,
            'created_by' => Auth::user()->id,
        ]);

        foreach($stockMutationRow->transfer_mutation_details as $transfer_mutation_detail) {
            $item_stock = ItemStock::where('id', $transfer_mutation_detail->item_stock_id)->first();

            // this IF means: transfer/move ALL/whole item stock to other warehouse
            if ($transfer_mutation_detail->transfer_quantity == $item_stock->quantity) {
                $item_stock->update([
                    'warehouse_id' => $stockMutationRow->warehouse_destination,
                    'reserved_quantity' => 0,

                    'updated_by' => Auth::user()->id,
                ]);
            }
        }
        DB::commit();
    }
}
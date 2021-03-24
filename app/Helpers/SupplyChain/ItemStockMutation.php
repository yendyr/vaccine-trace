<?php

namespace app\Helpers\SupplyChain;

use Modules\SupplyChain\Entities\OutboundMutationDetail;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ItemStockMutation
{
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
            $outboundDetailRow->update([
                'deleted_by' => Auth::user()->id,
            ]);
            OutboundMutationDetail::destroy($outboundDetailRow->id);
            
            if (sizeof($childRow->all_childs) > 0) {
                Self::unpickChilds($childRow, $stock_mutation_id);
            }
        }
    }
}
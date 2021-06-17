<?php

namespace app\Helpers\Accounting;

use Modules\Accounting\Entities\Journal;
use Modules\Accounting\Entities\JournalDetail;

use Yajra\DataTables\Facades\DataTables;

class JournalProcess
{
    public static function totalDebit($JournalId)
    {
        $total_debit = JournalDetail::where('journal_id', $JournalId)
                                ->sum('debit');

        if($total_debit) {
            return $total_debit;
        }
        else {
            return 0;
        }
    }

    public static function totalCredit($JournalId)
    {
        $total_credit = JournalDetail::where('journal_id', $JournalId)
                                ->sum('credit');

        if($total_credit) {
            return $total_credit;
        }
        else {
            return 0;
        }
    }

    public static function totalPriceAfterTax($PurchaseOrderId)
    {
        $PurchaseOrder = PurchaseOrder::where('id', $PurchaseOrderId)
                                        ->with(['purchase_order_details'])
                                        ->first();

        if($PurchaseOrder->purchase_order_details) {
            $totalPriceAfterTax = 0;

            foreach($PurchaseOrder->purchase_order_details as $purchase_order_detail) {
                $totalPriceAfterTax += $purchase_order_detail->order_quantity * $purchase_order_detail->each_price_before_vat * $purchase_order_detail->vat + ($purchase_order_detail->order_quantity * $purchase_order_detail->each_price_before_vat);
            }
            return $totalPriceAfterTax;
        }
        else {
            return 0;
        }
    }
}
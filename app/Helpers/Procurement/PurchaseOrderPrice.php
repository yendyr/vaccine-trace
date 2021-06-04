<?php

namespace app\Helpers\Procurement;

use Modules\Procurement\Entities\PurchaseOrder;
use Modules\Procurement\Entities\PurchaseOrderDetail;

use Yajra\DataTables\Facades\DataTables;

class PurchaseOrderPrice
{
    public static function totalPriceBeforeTax($PurchaseOrderId)
    {
        $PurchaseOrder = PurchaseOrder::where('id', $PurchaseOrderId)
                                        ->with(['purchase_order_details'])
                                        ->first();

        if($PurchaseOrder->purchase_order_details) {
            $totalPriceBeforeTax = 0;

            foreach($PurchaseOrder->purchase_order_details as $purchase_order_detail) {
                $totalPriceBeforeTax += $purchase_order_detail->order_quantity * $purchase_order_detail->each_price_before_vat;
            }
            return $totalPriceBeforeTax;
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
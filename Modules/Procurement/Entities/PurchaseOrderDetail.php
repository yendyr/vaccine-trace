<?php

namespace Modules\Procurement\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class PurchaseOrderDetail extends MainModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'purchase_order_id',
        'purchase_requisition_detail_id',

        'required_delivery_date',
        'description',

        'order_quantity',

        'vat',
        'each_price_before_vat',

        'prepared_to_grn_quantity',
        'processed_to_grn_quantity',
        
        'status',
        'created_by',
        'updated_by',
        'owned_by',
        'deleted_by',
    ];

    public function creator()
    {
        return $this->belongsTo(\Modules\Gate\Entities\User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(\Modules\Gate\Entities\User::class, 'updated_by');
    }

    public function purchase_requisition_detail()
    {
        return $this->belongsTo(\Modules\Procurement\Entities\PurchaseRequisitionDetail::class, 'purchase_requisition_detail_id');
    }

    public function current_primary_currency()
    {
        return $this->belongsTo(\Modules\GeneralSetting\Entities\Currency::class, 'current_primary_currency_id');
    }

    public function currency()
    {
        return $this->belongsTo(\Modules\GeneralSetting\Entities\Currency::class, 'currency_id');
    }

    public function purchase_order()
    {
        return $this->belongsTo(\Modules\Procurement\Entities\PurchaseOrder::class, 'purchase_order_id');
    }

    public function approvals()
    {
        return $this->hasMany(\Modules\Procurement\Entities\PurchaseOrderApproval::class, 'purchase_order_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($PurchaseOrder) {
            $PurchaseOrder->purchase_order_details()->delete(); 
            $PurchaseOrder->approvals()->delete(); 
        });
    }
}
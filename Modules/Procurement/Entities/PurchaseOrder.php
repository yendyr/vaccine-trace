<?php

namespace Modules\Procurement\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class PurchaseOrder extends MainModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'code',
        'transaction_date',
        'description',

        'transaction_reference_id',
        'transaction_reference_class',
        'transaction_reference_text',
        'transaction_reference_url',
        
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

    public function purchase_order_details()
    {
        return $this->hasMany(\Modules\Procurement\Entities\PurchaseOrderDetail::class, 'purchase_order_id');
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
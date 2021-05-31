<?php

namespace Modules\Procurement\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class PurchaseRequisition extends MainModel
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

    public function purchase_requisition_details()
    {
        return $this->hasMany(\Modules\Procurement\Entities\PurchaseRequisitionDetail::class, 'purchase_requisition_id');
    }

    public function approvals()
    {
        return $this->hasMany(\Modules\Procurement\Entities\PurchaseRequisitionApproval::class, 'purchase_requisition_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($PurchaseRequisition) {
            $PurchaseRequisition->purchase_requisition_details()->delete(); 
            $PurchaseRequisition->approvals()->delete(); 
        });
    }
}
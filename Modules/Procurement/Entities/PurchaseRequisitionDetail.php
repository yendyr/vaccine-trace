<?php

namespace Modules\Procurement\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class PurchaseRequisitionDetail extends MainModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'purchase_requisition_id',

        'coding',
        'item_id',
        'description',
        'highlight',
        'parent_coding',

        'request_quantity',
        'prepared_to_po_quantity',
        'processed_to_po_quantity',
        
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

    public function purchase_requisition()
    {
        return $this->belongsTo(\Modules\Procurement\Entities\PurchaseRequisition::class, 'purchase_requisition_id');
    }

    public function item()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\Item::class, 'item_id');
    }

    public function item_group()
    {
        return $this->belongsTo(\Modules\Procurement\Entities\PurchaseRequisitionDetail::class, 'parent_coding', 'coding');
    }

    public function all_childs()
    {
        return $this->hasMany(\Modules\Procurement\Entities\PurchaseRequisitionDetail::class, 'parent_coding', 'coding')->with('all_childs');
    }
}
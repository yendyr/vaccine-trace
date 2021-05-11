<?php

namespace Modules\PPC\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class WOWPTaskcardDetailItem extends MainModel
{
    use softDeletes;
    use Notifiable;

    protected $table = 'wo_wp_taskcard_detail_items';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid',

        'work_order_id',
        'work_package_id',
        'taskcard_id',
        'detail_id',
        'item_id',
        'quantity',
        'unit_id',
        'description',

        'item_json',
        'unit_json',
        'taskcard_json',

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

    public function work_order()
    {
        return $this->belongsTo(\Modules\PPC\Entities\WorkOrder::class, 'work_order_id');
    }

    public function work_package()
    {
        return $this->belongsTo(\Modules\PPC\Entities\WorkOrderWorkPackage::class, 'work_package_id');
    }

    public function taskcard()
    {
        return $this->belongsTo(\Modules\PPC\Entities\WorkOrderWorkPackageTaskcard::class, 'taskcard_id');
    }

    public function item()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\Item::class, 'item_id');
    }

    public function unit()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\Unit::class, 'unit_id');
    }

    public function category()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\ItemCategory::class, 'item_id');
    }
}

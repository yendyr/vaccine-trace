<?php

namespace Modules\PPC\Entities;

use Illuminate\Database\Eloquent\Model;

class WOWPTaskcardDetail extends Model
{
    protected $fillable = [];

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

    public function items()
    {
        return $this->hasMany(\Modules\PPC\Entities\WOWPTaskcardDetailItem::class, 'detail_id');
    }

    public function progresses()
    {
        return $this->hasMany(\Modules\PPC\Entities\WOWPTaskcardDetailProgress::class, 'detail_id')
            ->where('work_order_id', $this->work_order_id)
            ->where('work_package_id', $this->work_package_id)
            ->where('taskcard_id', $this->taskcard_id);
    }
}

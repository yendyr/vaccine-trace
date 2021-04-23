<?php

namespace Modules\PPC\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class WorkOrderWorkPackageTaskcard extends MainModel
{
    use softDeletes;
    use Notifiable;
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'uuid',
        'work_order_id',
        'work_package_id',
        'taskcard_id',
        'code',
        'name',
        'description',
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
        return $this->belongsTo(\Modules\PPC\Entities\Taskcard::class, 'taskcard_id');
    }
}

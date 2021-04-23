<?php

namespace Modules\PPC\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class WorkOrderWorkPackage extends MainModel
{
    use softDeletes;
    use Notifiable;
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'uuid',
        'work_order_id',
        'code',
        'name',
        'description',
        'performance_factor',
        'total_manhours',
        'file_attachment',
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
    
    public function workOrder()
    {
        return $this->belongsTo(\Modules\PPC\Entities\WorkOrder::class, 'work_order_id');
    }
}

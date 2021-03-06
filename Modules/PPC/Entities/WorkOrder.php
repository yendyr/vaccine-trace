<?php

namespace Modules\PPC\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class WorkOrder extends MainModel
{
    use softDeletes;
    use Notifiable;
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'uuid',
        'code',
        'name',
        'csn',
        'cso',
        'tsn',
        'tso',
        'aircraft_id',
        'aircraft_registration_number',
        'aircraft_serial_number',
        'station',
        'description',
        'parent_id',
        'file_attachment',
        'status',
        'created_by',
        'updated_by',
        'owned_by',
        'deleted_by',
    ];

    // Relationship

    public function creator()
    {
        return $this->belongsTo(\Modules\Gate\Entities\User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(\Modules\Gate\Entities\User::class, 'updated_by');
    }

    public function approvals()
    {
        return $this->hasMany(\Modules\PPC\Entities\WorkOrderApproval::class, 'work_order_id');
    }

    public function aircraft()
    {
        return $this->belongsTo(\Modules\PPC\Entities\AircraftConfiguration::class, 'aircraft_id');
    }

    public function parent()
    {
        return $this->belongsTo(\Modules\PPC\Entities\WorkOrder::class, 'parent_id');
    }

    public function workpackages()
    {
        return $this->hasMany(\Modules\PPC\Entities\WorkOrderWorkPackage::class, 'work_order_id');
    }

    public function taskcards()
    {
        return $this->hasMany(\Modules\PPC\Entities\WorkOrderWorkPackageTaskcard::class, 'work_order_id');
    }

    // Accessor
    public function getStatusLabelAttribute() {
        return ucfirst( config('ppc.work-order.status')[$this->status] ) ?? null;
    }

    public function getStatusColorAttribute() {
        return ucfirst( config('ppc.work-order.status-color')[$this->status] ) ?? 'plain';
    }
}

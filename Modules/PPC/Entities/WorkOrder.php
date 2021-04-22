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

    public function aircraft()
    {
        return $this->belongsTo(\Modules\PPC\Entities\AircraftConfiguration::class, 'aircraft_id');
    }

    public function parent()
    {
        return $this->belongsTo(\Modules\PPC\Entities\WorkOrder::class, 'parent_id');
    }
}

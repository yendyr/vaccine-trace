<?php

namespace Modules\FlightOperations\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AfmlDetailManifest extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'aircraft_flight_maintenance_logs_id',
        'person',
        'pax',
        'cargo_weight',
        'cargo_weight_unit_id',
        'pcm_number',
        'cm_number',
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

    public function cargo_weight_unit()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\Unit::class, 'cargo_weight_unit_id');
    }

    public function aircraft_flight_maintenance_log()
    {
        return $this->belongsTo(\Modules\FlightOperations\Entities\AircraftFlightMaintenanceLog::class, 'aircraft_flight_maintenance_log_id');
    }
}
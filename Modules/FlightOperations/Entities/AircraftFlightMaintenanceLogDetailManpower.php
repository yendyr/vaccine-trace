<?php

namespace Modules\FlightOperations\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AircraftFlightMaintenanceLogDetailManpower extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'aircraft_flight_maintenance_logs_id',
        'person_id',
        'in_flight_role_id',
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

    public function person()
    {
        return $this->belongsTo(\Modules\HumanResources\Entities\Employee::class, 'person_id');
    }

    public function in_flight_role()
    {
        return $this->belongsTo(\Modules\FlightOperations\Entities\InFlightRole::class, 'in_flight_role_id');
    }

    public function aircraft_flight_maintenance_log()
    {
        return $this->belongsTo(\Modules\FlightOperations\HumanResources\AircraftFlightMaintenanceLog::class, 'aircraft_flight_maintenance_log_id');
    }
}
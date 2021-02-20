<?php

namespace Modules\FlightOperations\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AfmlDetailItemRecord extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'afm_log_id',
        'item_id',
        'carried_forward_flight_hour',
        'carried_forward_flight_cycle',
        'carried_forward_flight_event',
        'after_day_flight_hour',
        'after_day_flight_cycle',
        'after_day_flight_event',

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

    public function aircraft_configuration_item()
    {
        return $this->belongsTo(\Modules\PPC\Entities\AircraftConfigurationDetail::class, 'item_id');
    }

    public function afm_log()
    {
        return $this->belongsTo(\Modules\FlightOperations\Entities\AfmLog::class, 'afm_log_id');
    }
}
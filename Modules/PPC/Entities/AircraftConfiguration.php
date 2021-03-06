<?php

namespace Modules\PPC\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class AircraftConfiguration extends MainModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'aircraft_type_id',
        'maintenance_program_id',

        'registration_number',
        'serial_number',
        'manufactured_date',
        'received_date',
        'code',
        'name',
        'description',

        'max_takeoff_weight',
        'max_takeoff_weight_unit_id',
        'max_landing_weight',
        'max_landing_weight_unit_id',
        'max_zero_fuel_weight',
        'max_zero_fuel_weight_unit_id',

        'fuel_capacity',
        'fuel_capacity_unit_id',
        'basic_empty_weight',
        'basic_empty_weight_unit_id',

        'initial_flight_hour',
        'initial_block_hour',
        'initial_flight_cycle',
        'initial_flight_event',
        'initial_start_date',
        
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

    public function aircraft_type()
    {
        return $this->belongsTo(\Modules\PPC\Entities\AircraftType::class, 'aircraft_type_id');
    }

    public function maintenance_program()
    {
        return $this->belongsTo(\Modules\PPC\Entities\MaintenanceProgram::class, 'maintenance_program_id');
    }

    public function manufacturer()
    {
        return $this->belongsTo(\Modules\GeneralSetting\Entities\Company::class, 'aircraft_type_id');
    }

    public function warehouse()
    {
        return $this->hasOne(\Modules\SupplyChain\Entities\Warehouse::class, 'aircraft_configuration_id');
    }

    public function afm_logs()
    {
        return $this->hasMany(\Modules\FlightOperations\Entities\AfmLog::class, 'aircraft_configuration_id');
    }

    public function approvals()
    {
        return $this->hasMany(\Modules\PPC\Entities\AircraftConfigurationApproval::class, 'aircraft_configuration_id');
    }

    public function max_takeoff_weight_unit()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\Unit::class, 'max_takeoff_weight_unit_id');
    }

    public function max_landing_weight_unit()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\Unit::class, 'max_landing_weight_unit_id');
    }

    public function max_zero_fuel_weight_unit()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\Unit::class, 'max_zero_fuel_weight_unit_id');
    }

    public function fuel_capacity_unit()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\Unit::class, 'fuel_capacity_unit_id');
    }

    public function basic_empty_weight_unit()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\Unit::class, 'basic_empty_weight_unit_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($AircraftConfiguration) {
            foreach($AircraftConfiguration->warehouse->item_stocks as $item_stock) {
                $item_stock->item_stock_initial_aging()->delete();
            }           
            $AircraftConfiguration->warehouse->item_stocks()->delete();             
            $AircraftConfiguration->warehouse()->delete();             
            $AircraftConfiguration->approvals()->delete();             
        });
    }
}
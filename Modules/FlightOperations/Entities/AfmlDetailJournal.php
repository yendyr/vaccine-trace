<?php

namespace Modules\FlightOperations\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AfmlDetailJournal extends MainModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'afm_log_id',
        'route_from',
        'route_to',
        'block_off',
        'take_off',
        'landing',
        'block_on',
        'timezone',
        'description',

        'sub_total_flight_hour',
        'sub_total_block_hour',
        'sub_total_cycle',
        'sub_total_event',

        'fuel_remaining',
        'fuel_remaining_unit_id',
        'fuel_uplifted',
        'fuel_uplifted_unit_id',
        'fuel_block',
        'fuel_block_unit_id',
        'fuel_burned',
        'fuel_burned_unit_id',
        'fuel_receipt_number',

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

    public function afm_log()
    {
        return $this->belongsTo(\Modules\FlightOperations\Entities\AfmLog::class, 'afm_log_id');
    }

    public function from_airport()
    {
        return $this->belongsTo(\Modules\GeneralSetting\Entities\Airport::class, 'route_from');
    }

    public function to_airport()
    {
        return $this->belongsTo(\Modules\GeneralSetting\Entities\Airport::class, 'route_to');
    }

    public function fuel_remaining_unit()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\Unit::class, 'fuel_remaining_unit_id');
    }

    public function fuel_uplifted_unit()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\Unit::class, 'fuel_uplifted_unit_id');
    }

    public function fuel_block_unit()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\Unit::class, 'fuel_block_unit_id');
    }

    public function fuel_burned_unit()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\Unit::class, 'fuel_burned_unit_id');
    }
}
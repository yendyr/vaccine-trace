<?php

namespace Modules\SupplyChain\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Warehouse extends MainModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'aircraft_configuration_id',

        'code',
        'name',
        'is_aircraft',
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

    public function item_stocks()
    {
        return $this->hasMany(\Modules\SupplyChain\Entities\ItemStock::class, 'warehouse_id');
    }

    public function aircraft_configuration()
    {
        return $this->belongsTo(\Modules\PPC\Entities\AircraftConfiguration::class, 'aircraft_configuration_id');
    }

    public function mutation_origins()
    {
        return $this->hasMany(\Modules\SupplyChain\Entities\StockMutation::class, 'warehouse_origin');
    }

    public function mutation_destinations()
    {
        return $this->hasMany(\Modules\SupplyChain\Entities\StockMutation::class, 'warehouse_destination');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($Warehouse) {
            $Warehouse->item_stocks()->delete();           
        });
    }
}
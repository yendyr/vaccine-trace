<?php

namespace Modules\SupplyChain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ItemStock extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'coding',
        'warehouse_id',
        'item_id',
        'serial_number',
        'alias_name',
        'description',
        'highlight',
        'parent_coding',

        'initial_flight_hour',
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

    public function warehouse()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\Warehouse::class, 'warehouse_id');
    }

    public function item()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\Item::class, 'item_id');
    }

    public function item_group()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\ItemStock::class, 'parent_coding', 'coding');
    }

    public function all_childs()
    {
        return $this->hasMany(\Modules\SupplyChain\Entities\ItemStock::class, 'parent_coding', 'coding')->with('all_childs');
    }
}
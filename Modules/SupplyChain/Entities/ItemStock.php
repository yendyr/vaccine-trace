<?php

namespace Modules\SupplyChain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class ItemStock extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    protected $appends = ['available_quantity'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'coding',
        'warehouse_id',
        'detailed_item_location',
        'inbound_mutation_id',
        'item_id',
        'serial_number',
        'alias_name',
        'description',
        'highlight',
        'parent_coding',

        'quantity',
        'used_quantity',
        'loaned_quantity',
        'reserved_quantity',
        
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

    public function inbound_mutation()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\StockMutation::class, 'inbound_mutation_id');
    }

    public function outbound_mutation_details()
    {
        return $this->hasMany(\Modules\SupplyChain\Entities\OutboundMutationDetail::class, 'item_stock_id');
    }

    public function item()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\Item::class, 'item_id');
    }

    public function item_stock_initial_aging()
    {
        return $this->hasOne(\Modules\PPC\Entities\ItemStockInitialAging::class, 'item_stock_id');
    }

    public function item_stock_agings()
    {
        return $this->hasMany(\Modules\PPC\Entities\ItemStockAging::class, 'item_stock_id');
    }

    public function item_group()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\ItemStock::class, 'parent_coding', 'coding');
    }

    public function all_childs()
    {
        return $this->hasMany(\Modules\SupplyChain\Entities\ItemStock::class, 'parent_coding', 'coding')->with('all_childs');
    }

    public function getAvailableQuantityAttribute()
    {
        return '<strong>' . ($this->quantity - ($this->loaned_quantity + $this->used_quantity + $this->reserved_quantity)) . '</strong>';
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($ItemStock) {
             $ItemStock->outbound_mutation_details()->delete();
             $ItemStock->item_stock_initial_aging()->delete();
        });
    }
}
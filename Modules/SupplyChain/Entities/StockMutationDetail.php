<?php

namespace Modules\SupplyChain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class StockMutationDetail extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'stock_mutation_id',

        'coding',
        'detailed_item_location',
        'item_id',
        'serial_number',
        'alias_name',
        'description',
        'highlight',
        'parent_coding',

        'quantity',
        'used_quantity',
        'loaned_quantity',
        
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

    public function stock_mutation()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\StockMutation::class, 'stock_mutation_id');
    }

    public function item()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\Item::class, 'item_id');
    }

    public function mutation_detail_initial_aging()
    {
        return $this->hasOne(\Modules\SupplyChain\Entities\StockMutationDetailInitialAging::class, 'stock_mutation_detail_id');
    }

    public function item_group()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\StockMutationDetail::class, 'parent_coding', 'coding');
    }

    public function all_childs()
    {
        return $this->hasMany(\Modules\SupplyChain\Entities\StockMutationDetail::class, 'parent_coding', 'coding')->with('all_childs');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($StockMutationDetail) {
             $StockMutationDetail->mutation_detail_initial_aging()->delete();
        });
    }
}
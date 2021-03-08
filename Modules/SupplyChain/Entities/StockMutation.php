<?php

namespace Modules\SupplyChain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class StockMutation extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'warehouse_origin',
        'warehouse_destination',
        'transaction_reference_id',
        'transaction_reference_class',

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

    public function origin()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\Warehouse::class, 'warehouse_origin');
    }

    public function destination()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\Warehouse::class, 'warehouse_destination');
    }

    public function stock_mutation_details()
    {
        return $this->hasMany(\Modules\SupplyChain\Entities\StockMutationDetail::class, 'stock_mutation_id');
    }

    public function item_stocks()
    {
        return $this->hasMany(\Modules\SupplyChain\Entities\ItemStock::class, 'inbound_mutation_id');
    }

    public function outbond_mutation_details()
    {
        return $this->hasMany(\Modules\SupplyChain\Entities\OutbondMutationDetail::class, 'stock_mutation_id');
    }

    public function approvals()
    {
        return $this->hasMany(\Modules\SupplyChain\Entities\StockMutationApproval::class, 'stock_mutation_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($StockMutation) {
            $StockMutation->stock_mutation_details()->delete();
            $StockMutation->item_stocks()->delete();
            $StockMutation->outbond_mutation_details()->delete();
            $StockMutation->approvals()->delete(); 
        });
    }
}
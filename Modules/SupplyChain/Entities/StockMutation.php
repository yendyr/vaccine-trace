<?php

namespace Modules\SupplyChain\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class StockMutation extends MainModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'code',
        'transaction_date',
        'warehouse_origin',
        'warehouse_destination',

        'transaction_reference_id',
        'transaction_reference_class',
        'transaction_reference_text',
        'transaction_reference_url',

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

    public function inbound_mutation_details()
    {
        return $this->hasMany(\Modules\SupplyChain\Entities\InboundMutationDetail::class, 'stock_mutation_id');
    }

    public function item_stocks()
    {
        return $this->hasMany(\Modules\SupplyChain\Entities\ItemStock::class, 'inbound_mutation_id');
    }

    public function outbound_mutation_details()
    {
        return $this->hasMany(\Modules\SupplyChain\Entities\OutboundMutationDetail::class, 'stock_mutation_id');
    }

    public function transfer_mutation_details()
    {
        return $this->hasMany(\Modules\SupplyChain\Entities\TransferMutationDetail::class, 'stock_mutation_id');
    }

    public function approvals()
    {
        return $this->hasMany(\Modules\SupplyChain\Entities\StockMutationApproval::class, 'stock_mutation_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($StockMutation) {
            foreach ($StockMutation->inbound_mutation_details as $inbound_mutation_detail) {
                $inbound_mutation_detail->mutation_detail_initial_aging()->delete();
            }
            $StockMutation->stock_mutation_details()->delete();
            $StockMutation->item_stocks()->delete();
            $StockMutation->approvals()->delete(); 
        });
    }
}
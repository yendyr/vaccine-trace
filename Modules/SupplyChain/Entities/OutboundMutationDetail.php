<?php

namespace Modules\SupplyChain\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class OutboundMutationDetail extends MainModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'stock_mutation_id',
        'item_stock_id',

        'outbound_quantity',
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

    public function stock_mutation()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\StockMutation::class, 'stock_mutation_id');
    }

    public function item_stock()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\ItemStock::class, 'item_stock_id');
    }
}
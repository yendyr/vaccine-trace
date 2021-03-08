<?php

namespace Modules\PPC\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class ItemStockAging extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'item_stock_id',

        'transaction_reference_id',
        'transaction_reference_class',
        'transaction_reference_text',
        'transaction_reference_url',

        'flight_hour',
        'block_hour',
        'flight_cycle',
        'flight_event',
        
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

    public function item_stock()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\ItemStock::class, 'item_stock_id');
    }

    public function afm_log_reference()
    {
        return $this->belongsTo(\Modules\FlightOperation\Entities\AfmLog::class, 'transaction_reference_id');
    }
}
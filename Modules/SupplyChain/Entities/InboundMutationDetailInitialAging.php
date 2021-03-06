<?php

namespace Modules\SupplyChain\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class InboundMutationDetailInitialAging extends MainModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'inbound_mutation_detail_id',

        'initial_flight_hour',
        'initial_block_hour',
        'initial_flight_cycle',
        'initial_flight_event',
        'initial_start_date',
        'expired_date',
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

    public function inbound_mutation_detail()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\InboundMutationDetail::class, 'inbound_mutation_detail_id');
    }
}
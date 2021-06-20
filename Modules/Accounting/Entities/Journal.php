<?php

namespace Modules\Accounting\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Journal extends MainModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    protected $appends = ['transaction_reference_code'];

    use Notifiable;

    protected $fillable = [
        'uuid',
        'code',

        'transaction_date',
        'document_date',
        'event_date',
        'description',

        'current_primary_currency_id',
        'currency_id',
        'exchange_rate',

        'transaction_reference_id',
        'transaction_reference_class',
        'transaction_reference_text',
        'transaction_reference_url',

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

    public function current_primary_currency()
    {
        return $this->belongsTo(\Modules\GeneralSetting\Entities\Currency::class, 'current_primary_currency_id');
    }

    public function currency()
    {
        return $this->belongsTo(\Modules\GeneralSetting\Entities\Currency::class, 'currency_id');
    }

    public function stock_mutation()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\StockMutation::class, 'transaction_reference_id', 'id');
    }

    public function journal_details()
    {
        return $this->hasMany(\Modules\Accounting\Entities\JournalDetail::class, 'journal_id');
    }

    public function approvals()
    {
        return $this->hasMany(\Modules\Accounting\Entities\JournalApproval::class, 'journal_id');
    }

    public function getTransactionReferenceCodeAttribute()
    {
        if ($this->transaction_reference_text == 'Warehouse Stock Inbound') {
            return $this->stock_mutation->code;
        }
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($Journal) {
            $Journal->journal_details()->delete(); 
            $Journal->approvals()->delete(); 
        });
    }
}
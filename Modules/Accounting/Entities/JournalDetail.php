<?php

namespace Modules\Accounting\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class JournalDetail extends MainModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];

    use Notifiable;

    protected $fillable = [
        'uuid',
        'code',

        'journal_id',
        'coa_id',
        'debit',
        'credit',
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

    public function journal()
    {
        return $this->belongsTo(\Modules\Accounting\Entities\Journal::class, 'journal_id');
    }

    public function coa()
    {
        return $this->belongsTo(\Modules\Accounting\Entities\ChartOfAccount::class, 'coa_id');
    }
}
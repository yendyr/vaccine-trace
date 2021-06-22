<?php

namespace Modules\Accounting\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ChartOfAccount extends MainModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];

    use Notifiable;

    protected $fillable = [
        'uuid',
        'code',

        'name',
        'description',
        'chart_of_account_class_id',
        'parent_id',

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

    public function chart_of_account_class()
    {
        return $this->belongsTo(\Modules\Accounting\Entities\ChartOfAccountClass::class, 'chart_of_account_class_id');
    }

    public function chart_of_account()
    {
        return $this->belongsTo(\Modules\Accounting\Entities\ChartOfAccount::class, 'parent_id');
    }

    public function journal_details()
    {
        return $this->hasMany(\Modules\Accounting\Entities\JournalDetail::class, 'coa_id', 'id');
    }

    public function all_childs()
    {
        return $this->hasMany(\Modules\Accounting\Entities\ChartOfAccount::class, 'parent_id', 'id')->with('all_childs');
    }

    public function parent()
    {
        return $this->belongsTo(\Modules\Accounting\Entities\ChartOfAccount::class, 'parent_id', 'id');
    }

    public function children ()
    {
        return $this->hasMany(\Modules\Accounting\Entities\ChartOfAccount::class, 'parent_id', 'id');
    }

    public function getAllChilds ()
    {
        $coas = new Collection();

        foreach ($this->children as $coa) {
            $coas->push($coa);
            $coas = $coas->merge($coa->getAllChilds()->pluck('id'));
        }
        return $coas;
    }
}

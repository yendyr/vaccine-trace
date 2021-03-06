<?php

namespace Modules\SupplyChain\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class ItemCategory extends MainModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',
        'code',
        
        'name',
        'description',
        'item_type',

        'sales_coa_id',
        'inventory_coa_id',
        'cost_coa_id',
        'inventory_adjustment_coa_id',
        'work_in_progress_coa_id',

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

    public function sales_coa()
    {
        return $this->belongsTo(\Modules\Accounting\Entities\ChartOfAccount::class, 'sales_coa_id');
    }

    public function inventory_coa()
    {
        return $this->belongsTo(\Modules\Accounting\Entities\ChartOfAccount::class, 'inventory_coa_id');
    }

    public function cost_coa()
    {
        return $this->belongsTo(\Modules\Accounting\Entities\ChartOfAccount::class, 'cost_coa_id');
    }

    public function inventory_adjustment_coa()
    {
        return $this->belongsTo(\Modules\Accounting\Entities\ChartOfAccount::class, 'inventory_adjustment_coa_id');
    }

    public function work_in_progress_coa()
    {
        return $this->belongsTo(\Modules\Accounting\Entities\ChartOfAccount::class, 'work_in_progress_coa_id');
    }

    public function items()
    {
        return $this->hasMany(\Modules\SupplyChain\Entities\Item::class, 'category_id');
    }
}
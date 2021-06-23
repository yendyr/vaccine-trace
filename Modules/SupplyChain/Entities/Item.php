<?php

namespace Modules\SupplyChain\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Item extends MainModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    protected $appends = [
        'active_sales_coa_id',
        'active_inventory_coa_id',
        'active_cost_coa_id',
        'active_inventory_adjustment_coa_id',
        'active_work_in_progress_coa_id',
    ];
    use Notifiable;

    protected $fillable = [
        'uuid',
        'code',
        'name',
        'model',
        'type',
        'description',

        'reorder_stock_level',
        'taxable',

        'category_id',
        'primary_unit_id',
        'manufacturer_id',

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

    public function getActiveSalesCoaIdAttribute()
    {
        if ($this->sales_coa_id) {
            return $this->sales_coa_id;
        }
        else {
            return $this->category->sales_coa_id;
        }
    }

    public function inventory_coa()
    {
        return $this->belongsTo(\Modules\Accounting\Entities\ChartOfAccount::class, 'inventory_coa_id');
    }

    public function getActiveInventoryCoaIdAttribute()
    {
        if ($this->inventory_coa_id) {
            return $this->inventory_coa_id;
        }
        else {
            return $this->category->inventory_coa_id;
        }
    }

    public function cost_coa()
    {
        return $this->belongsTo(\Modules\Accounting\Entities\ChartOfAccount::class, 'cost_coa_id');
    }

    public function getActiveCostCoaIdAttribute()
    {
        if ($this->cost_coa_id) {
            return $this->cost_coa_id;
        }
        else {
            return $this->category->cost_coa_id;
        }
    }

    public function inventory_adjustment_coa()
    {
        return $this->belongsTo(\Modules\Accounting\Entities\ChartOfAccount::class, 'inventory_adjustment_coa_id');
    }

    public function getActiveInventoryAdjustmentCoaIdAttribute()
    {
        if ($this->inventory_adjustment_coa_id) {
            return $this->inventory_adjustment_coa_id;
        }
        else {
            return $this->category->inventory_adjustment_coa_id;
        }
    }

    public function work_in_progress_coa()
    {
        return $this->belongsTo(\Modules\Accounting\Entities\ChartOfAccount::class, 'work_in_progress_coa_id');
    }

    public function getActiveWorkInProgressCoaIdAttribute()
    {
        if ($this->work_in_progress_coa_id) {
            return $this->work_in_progress_coa_id;
        }
        else {
            return $this->category->work_in_progress_coa_id;
        }
    }

    public function unit()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\Unit::class, 'primary_unit_id');
    }

    public function category()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\ItemCategory::class, 'category_id');
    }

    public function item_stocks()
    {
        return $this->hasMany(\Modules\SupplyChain\Entities\ItemStock::class, 'item_id');
    }

    public function manufacturer()
    {
        return $this->belongsTo(\Modules\GeneralSetting\Entities\Company::class, 'manufacturer_id');
    }

    public function configuration_template_details()
    {
        return $this->hasMany(\Modules\PPC\Entities\AircraftConfigurationTemplateDetail::class, 'item_id');
    }
}

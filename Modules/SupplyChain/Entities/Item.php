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
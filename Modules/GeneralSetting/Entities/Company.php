<?php

namespace Modules\GeneralSetting\Entities;

use App\SACModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends SACModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid', 
        'code', 
        'name', 
        'gst_number', 
        'npwp_number', 
        'description', 
        'is_customer', 
        'is_supplier', 
        'is_manufacturer',

        'account_receivable_coa_id',
        'sales_discount_coa_id',
        'account_payable_coa_id',
        'purchase_discount_coa_id',

        'owned_by', 
        'status', 
        'updated_by',
        'created_by',
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

    public function contacts()
    {
        return $this->hasMany(\Modules\GeneralSetting\Entities\CompanyDetailContact::class, 'company_id');
    }

    public function addresses()
    {
        return $this->hasMany(\Modules\GeneralSetting\Entities\CompanyDetailAddress::class, 'company_id');
    }

    public function banks()
    {
        return $this->hasMany(\Modules\GeneralSetting\Entities\CompanyDetailBank::class, 'company_id');
    }

    public function account_receivable_coa()
    {
        return $this->belongsTo(\Modules\Accounting\Entities\ChartOfAccount::class, 'account_receivable_coa_id');
    }

    public function sales_discount_coa()
    {
        return $this->belongsTo(\Modules\Accounting\Entities\ChartOfAccount::class, 'sales_discount_coa_id');
    }

    public function account_payable_coa()
    {
        return $this->belongsTo(\Modules\Accounting\Entities\ChartOfAccount::class, 'account_payable_coa_id');
    }

    public function purchase_discount_coa()
    {
        return $this->belongsTo(\Modules\Accounting\Entities\ChartOfAccount::class, 'purchase_discount_coa_id');
    }

    public function items()
    {
        return $this->hasMany(\Modules\SupplyChain\Entities\Item::class, 'manufacturer_id');
    }

    public function employees()
    {
        return $this->hasMany(\Modules\HumanResources\Entities\Employee::class, 'employee_id');
    }
}
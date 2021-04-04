<?php

namespace Modules\GeneralSetting\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CompanyDetailBank extends MainModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'company_id', 
        'uuid', 
        'label', 
        'bank_name', 
        'bank_branch', 
        'account_holder_name', 
        'account_number', 
        'swift_code', 
        'description', 
        'chart_of_account_id', 
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

    public function company()
    {
        return $this->belongsTo(\Modules\GeneralSetting\Entities\Company::class, 'company_id');
    }

    public function chart_of_account()
    {
        return $this->belongsTo(\Modules\Accounting\Entities\ChartOfAccount::class, 'chart_of_account_id');
    }
}
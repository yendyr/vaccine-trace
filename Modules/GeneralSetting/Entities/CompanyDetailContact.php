<?php

namespace Modules\GeneralSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CompanyDetailContact extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'company_id', 
        'uuid', 
        'label', 
        'name', 
        'email', 
        'mobile_number', 
        'office_number', 
        'fax_number', 
        'other_number', 
        'website', 
        'website_alternative', 
        'website_alternative', 
        'description', 
        'owned_by', 
        'status', 
        'updated_by',
        'created_by'
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
}
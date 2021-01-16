<?php

namespace Modules\GeneralSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Model
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

    public function contact()
    {
        return $this->hasMany(\Modules\Gate\Entities\CompanyDetailContact::class, 'company_id');
    }

    public function address()
    {
        return $this->hasMany(\Modules\Gate\Entities\CompanyDetailAddress::class, 'company_id');
    }

    public function bank()
    {
        return $this->hasMany(\Modules\Gate\Entities\CompanyDetailBank::class, 'company_id');
    }
}
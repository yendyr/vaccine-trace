<?php

namespace Modules\GeneralSetting\Entities;

use App\SACModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CompanyDetailAddress extends SACModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'company_id', 
        'uuid', 
        'label', 
        'name', 
        'street', 
        'city', 
        'province', 
        'country_id', 
        'post_code', 
        'latitude', 
        'longitude', 
        'description', 
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

    public function country()
    {
        return $this->belongsTo(\Modules\GeneralSetting\Entities\Country::class, 'country_id', 'id');
    }
}
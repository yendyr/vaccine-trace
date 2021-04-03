<?php

namespace Modules\HumanResources\Entities;

use App\SACModel;
use Illuminate\Database\Eloquent\Model;

class Employee extends SACModel
{
    protected $fillable = [
        'uuid', 
        'empid', 
        'fullname', 
        'nickname', 
        'photo', 
        'pob', 
        'dob', 
        'gender', 
        'email',
        'religion', 
        'mobile01', 
        'mobile02', 
        'bloodtype', 
        'maritalstatus', 
        'empdate', 
        'probation',
        'cessdate', 
        'cesscode', 
        'recruitby', 
        'emptype', 
        'workgrp', 
        'site', 
        'acssgrp', 
        'achgrp',
        'orglvl', 
        'orgcode', 
        'title', 
        'jobtitle', 
        'jobgrp', 
        'costcode', 
        'remark', 
        'user_id', 
        'company_id', 
        'owned_by', 
        'status'
    ];

    protected $table = 'hr_employees';

    public function organizationStructure()
    {
        return $this->belongsTo(OrganizationStructure::class, 'orgcode', 'orgcode');
    }

    public function workingGroup()
    {
        return $this->belongsTo(WorkingGroup::class, 'workgrp', 'workgroup');
    }

    public function users()
    {
        return $this->hasMany(\Modules\Gate\Entities\User::class, 'employee_id');
    }

    public function company()
    {
        return $this->belongsTo(\Modules\GeneralSetting\Entities\Company::class, 'company_id');
    }
}
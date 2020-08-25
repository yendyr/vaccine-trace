<?php

namespace Modules\HumanResources\Entities;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'uuid', 'empid', 'fullname', 'nickname', 'photo', 'pob', 'dob', 'gender', 'email',
        'religion', 'mobile01', 'mobile02', 'bloodtype', 'maritalstatus', 'empdate', 'probation',
        'cessdate', 'cesscode', 'recruitby', 'emptype', 'workgrp', 'site', 'acssgrp', 'achgrp',
        'orglvl', 'orgcode', 'title', 'jobtitle', 'jobgrp', 'costcode', 'remark', 'owned_by', 'status'
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
}

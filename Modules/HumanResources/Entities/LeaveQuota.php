<?php

namespace Modules\HumanResources\Entities;

use Illuminate\Database\Eloquent\Model;

class LeaveQuota extends Model
{
    protected $fillable = [
        'uuid', 'empid', 'quotayear', 'quotacode', 'quotastartdate', 'quotaexpdate', 'quotaallocdate',
        'quotaqty','quotabal','remark','owned_by', 'status'
    ];

    protected $table = 'hr_leave_quotas';
}

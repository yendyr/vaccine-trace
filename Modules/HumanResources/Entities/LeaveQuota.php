<?php

namespace Modules\HumanResources\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;

class LeaveQuota extends MainModel
{
    protected $fillable = [
        'uuid', 'empid', 'quotayear', 'quotacode', 'quotastartdate', 'quotaexpdate', 'quotaallocdate',
        'quotaqty','quotabal','remark','owned_by', 'status'
    ];

    protected $table = 'hr_leave_quotas';
}

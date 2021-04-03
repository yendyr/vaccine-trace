<?php

namespace Modules\HumanResources\Entities;

use App\SACModel;
use Illuminate\Database\Eloquent\Model;

class WorkingGroup extends SACModel
{
    protected $fillable = [
        'uuid', 'workgroup', 'workname', 'shiftstatus', 'shiftrolling',
        'rangerolling', 'roundtime', 'workfinger', 'restfinger', 'remark', 'owned_by', 'status'
    ];

    protected $table = 'hr_working_groups';
}

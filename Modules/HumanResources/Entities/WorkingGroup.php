<?php

namespace Modules\HumanResources\Entities;

use Illuminate\Database\Eloquent\Model;

class WorkingGroup extends Model
{
    protected $fillable = [
        'uuid', 'workgroup', 'workname', 'shiftstatus', 'shiftrolling',
        'rangerolling', 'roundtime', 'workfinger', 'restfinger', 'remark', 'owned_by', 'status'
    ];
}

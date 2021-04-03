<?php

namespace Modules\HumanResources\Entities;

use App\SACModel;
use Illuminate\Database\Eloquent\Model;

class WorkingHourAttendance extends SACModel
{
    protected $fillable = [
        'uuid', 'empid', 'attdtype', 'workdate', 'timestart', 'datestart', 'timefinish','datefinish',
        'processedon', 'validateon', 'rndatestart', 'rntimestart', 'rndatefinish', 'rntimefinish', 'owned_by', 'status'
    ];

    protected $table = 'hr_working_hour_attendances';
}

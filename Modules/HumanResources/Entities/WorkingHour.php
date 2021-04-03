<?php

namespace Modules\HumanResources\Entities;

use App\SACModel;
use Illuminate\Database\Eloquent\Model;

class WorkingHour extends SACModel
{
    protected $fillable = [
        'uuid', 'empid', 'workdate', 'shiftno', 'whtimestart', 'whdatestart', 'whtimefinish','whdatefinish',
        'rstimestart', 'rsdatestart', 'rstimefinish', 'rsdatefinish', 'stdhours', 'minhours', 'worktype', 'workstatus',
        'processedon', 'leavehours', 'attdhours', 'overhours', 'attdstatus', 'owned_by', 'status'
    ];

    protected $table = 'hr_working_hours';
}

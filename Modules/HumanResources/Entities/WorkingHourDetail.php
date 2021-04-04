<?php

namespace Modules\HumanResources\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;

class WorkingHourDetail extends MainModel
{
    protected $fillable = [
        'uuid', 'empid', 'attdtype', 'workdate', 'timestart', 'datestart', 'timefinish','datefinish',
        'processedon', 'mainattd', 'caldatestart', 'caltimestart', 'caldatefinish', 'caltimefinish', 'owned_by', 'status'
    ];

    protected $table = 'hr_working_hour_details';
}

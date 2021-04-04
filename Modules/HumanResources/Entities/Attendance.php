<?php

namespace Modules\HumanResources\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;

class Attendance extends MainModel
{
    protected $fillable = [
        'uuid', 'empid', 'attdtype', 'attddate', 'attdtime',
        'deviceid', 'inputon', 'owned_by', 'status'
    ];

    protected $table = 'hr_attendances';
}

<?php

namespace Modules\HumanResources\Entities;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'uuid', 'empid', 'attdtype', 'attddate', 'attdtime',
        'deviceid', 'inputon', 'owned_by', 'status'
    ];

    protected $table = 'hr_attendances';
}

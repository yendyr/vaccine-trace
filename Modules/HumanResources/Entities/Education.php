<?php

namespace Modules\HumanResources\Entities;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = [
        'uuid', 'empid', 'instname', 'startperiod', 'finishperiod', 'city', 'state', 'country',
        'major01', 'major02', 'minor01', 'minor02', 'edulvl', 'remark', 'owned_by', 'status'
    ];

    protected $table = 'hr_educations';
}

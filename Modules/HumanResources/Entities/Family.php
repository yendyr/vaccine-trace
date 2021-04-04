<?php

namespace Modules\HumanResources\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;

class Family extends MainModel
{
    protected $fillable = [
        'uuid', 'empid', 'famid', 'relationship', 'fullname', 'pob', 'dob', 'gender',
        'maritalstatus', 'edumajor', 'edulvl', 'job', 'remark', 'owned_by', 'status'
    ];

    protected $table = 'hr_families';
}

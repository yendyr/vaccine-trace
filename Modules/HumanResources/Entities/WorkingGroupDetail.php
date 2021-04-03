<?php

namespace Modules\HumanResources\Entities;

use App\SACModel;
use Illuminate\Database\Eloquent\Model;

class WorkingGroupDetail extends SACModel
{
    protected $fillable = [
        'uuid', 'workgroup', 'daycode', 'shiftno', 'whtimestart', 'whtimefinish',
        'rstimestart', 'rstimefinish', 'stdhours', 'minhours', 'worktype', 'owned_by', 'status'
    ];

    protected $table = 'hr_working_group_details';
}

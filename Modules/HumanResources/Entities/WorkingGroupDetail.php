<?php

namespace Modules\HumanResources\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;

class WorkingGroupDetail extends MainModel
{
    protected $fillable = [
        'uuid', 'workgroup', 'daycode', 'shiftno', 'whtimestart', 'whtimefinish',
        'rstimestart', 'rstimefinish', 'stdhours', 'minhours', 'worktype', 'owned_by', 'status'
    ];

    protected $table = 'hr_working_group_details';
}

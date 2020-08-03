<?php

namespace Modules\HumanResources\Entities;

use Illuminate\Database\Eloquent\Model;

class WorkingGroupDetail extends Model
{
    protected $fillable = [
        'uuid', 'workgroup', 'daycode', 'shiftno', 'whtimestart', 'whtimefinish',
        'rstimestart', 'rstimefinish', 'stdhours', 'minhours', 'worktype', 'owned_by', 'status'
    ];
}

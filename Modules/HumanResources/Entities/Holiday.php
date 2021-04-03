<?php

namespace Modules\HumanResources\Entities;

use App\SACModel;
use Illuminate\Database\Eloquent\Model;

class Holiday extends SACModel
{
    protected $fillable = [
        'uuid', 'holidayyear', 'holidaydate', 'holidaycode', 'remark', 'owned_by', 'status'
    ];

    protected $table = 'hr_holidays';
}

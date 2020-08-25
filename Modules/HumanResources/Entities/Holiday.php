<?php

namespace Modules\HumanResources\Entities;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $fillable = [
        'uuid', 'holidayyear', 'holidaydate', 'holidaycode', 'remark', 'owned_by', 'status'
    ];

    protected $table = 'hr_holidays';
}

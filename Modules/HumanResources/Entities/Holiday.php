<?php

namespace Modules\HumanResources\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Holiday extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'uuid', 'holidayyear', 'holidaydate', 'holidaycode', 'remark', 'owned_by', 'status'
    ];

    protected $table = 'hr_holidays';
}

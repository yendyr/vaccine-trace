<?php

namespace Modules\HumanResources\Entities;

use App\SACModel;
use Illuminate\Database\Eloquent\Model;

class Request extends SACModel
{
    protected $fillable = [
        'uuid', 'txnperiod', 'reqcode', 'reqtype','docno', 'docdate',
        'empid', 'workdate', 'shiftno', 'whtimestart', 'whdatestart', 'whtimefinish','whdatefinish',
        'rstimestart', 'rsdatestart', 'rstimefinish', 'rsdatefinish', 'stdhours', 'minhours',
        'worktype', 'workstatus', 'quotayear', 'remark', 'owned_by', 'status'
    ];

    protected $table = 'hr_requests';

    /**
     * Retrieve the child model for a bound value.
     *
     * @param string $childType
     * @param mixed $value
     * @param string|null $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveChildRouteBinding($childType, $value, $field)
    {

    }
}

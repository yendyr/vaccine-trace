<?php

namespace Modules\HumanResources\Entities;

use App\SACModel;
use Illuminate\Database\Eloquent\Model;

class Address extends SACModel
{
    protected $fillable = [
        'uuid', 'empid', 'famid', 'addrid', 'street', 'area', 'city', 'state', 'country',
        'postcode', 'tel01', 'tel02', 'remark', 'owned_by', 'status'
    ];

    protected $table = 'hr_addresses';
}

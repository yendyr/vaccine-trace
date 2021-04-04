<?php

namespace Modules\HumanResources\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;

class HrLookup extends MainModel
{
    protected $fillable = [
        'uuid', 'mainkey', 'subkey', 'lkey', 'maingrp', 'subgrp', 'grp', 'value', 'remark', 'owned_by', 'status'
    ];

    protected $table = 'hr_lookups';
}

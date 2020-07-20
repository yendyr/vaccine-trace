<?php

namespace Modules\Examples\Entities;

use Illuminate\Database\Eloquent\Model;

class Example extends Model
{
    protected $fillable = [
        'uuid', 'name', 'code', 'owned_by', 'status', 'created_by'
    ];
}

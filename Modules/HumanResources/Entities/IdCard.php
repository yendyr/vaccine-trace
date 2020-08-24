<?php

namespace Modules\HumanResources\Entities;

use Illuminate\Database\Eloquent\Model;

class IdCard extends Model
{
    protected $fillable = [
        'uuid', 'empid', 'idcardtype', 'idcardno', 'idcarddate', 'idcardexpdate', 'owned_by', 'status'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'empid', 'empid');
    }
}

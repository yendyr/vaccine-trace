<?php

namespace Modules\HumanResources\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;

class IdCard extends MainModel
{
    protected $fillable = [
        'uuid', 'empid', 'idcardtype', 'idcardno', 'idcarddate', 'idcardexpdate', 'owned_by', 'status'
    ];

    protected $table = 'hr_id_cards';

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'empid', 'empid');
    }
}

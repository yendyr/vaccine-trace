<?php

namespace Modules\PPC\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class WOWPTaskcardItem extends MainModel
{
    use softDeletes;
    use Notifiable;

    protected $table = 'wo_wp_taskcard_items';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid',

        'work_order_id',
        'work_package_id',
        'taskcard_id',
        'item_id',
        'quantity',
        'unit_id',
        'description',

        'status',
        'created_by',
        'updated_by',
        'owned_by',
        'deleted_by',
    ];
}

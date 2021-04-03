<?php

namespace Modules\FlightOperations\Entities;

use App\SACModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AfmlDetailRectification extends SACModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'afm_log_id',
        'afml_detail_discrepancy_id',
        'code',
        'title',
        'description',
        'performed_by',

        'status',
        'created_by',
        'updated_by',
        'owned_by',
        'deleted_by',
    ];

    public function creator()
    {
        return $this->belongsTo(\Modules\Gate\Entities\User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(\Modules\Gate\Entities\User::class, 'updated_by');
    }

    public function employee()
    {
        return $this->belongsTo(\Modules\HumanResources\Entities\Employee::class, 'performed_by');
    }

    public function afm_log()
    {
        return $this->belongsTo(\Modules\FlightOperations\Entities\AfmLog::class, 'afm_log_id');
    }

    public function afml_detail_discrepancy()
    {
        return $this->belongsTo(\Modules\FlightOperations\Entities\AfmlDetailDiscrepancy::class, 'afml_detail_discrepancy_id');
    }
}
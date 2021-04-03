<?php

namespace Modules\FlightOperations\Entities;

use App\SACModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AfmlDetailDiscrepancy extends SACModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'code',
        'afm_log_id',
        'title',
        'description',
        'progress_status',

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

    public function afm_log()
    {
        return $this->belongsTo(\Modules\FlightOperations\Entities\AfmLog::class, 'afm_log_id');
    }

    public function rectification_details()
    {
        return $this->hasMany(\Modules\FlightOperations\Entities\AfmlDetailRectification::class, 'afml_detail_discrepancy_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($AFML) {
             $AFML->rectification_details()->delete();
        });
    }
}
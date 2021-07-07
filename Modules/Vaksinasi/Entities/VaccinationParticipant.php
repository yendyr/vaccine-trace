<?php

namespace Modules\Vaksinasi\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class VaccinationParticipant extends MainModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',
        
        'date',
        'squad_id',
        'id_type',
        'id_number',
        'category',
        'name',
        'address',
        'vaccine_used',

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
    
    public function squad()
    {
        return $this->belongsTo(\Modules\Vaksinasi\Entities\Squad::class, 'squad_id');
    }
}
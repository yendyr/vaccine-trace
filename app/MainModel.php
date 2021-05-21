<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;

class MainModel extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    /**
     * Scope a query to only user company data.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompanyData($query) 
    {
        return $query->where('owned_by', Auth::user()->company_id);
    }

}

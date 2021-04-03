<?php

namespace Modules\HumanResources\Entities;

use App\SACModel;
use Illuminate\Database\Eloquent\Model;

class OrganizationStructureTitle extends SACModel
{
    protected $fillable = [
        'uuid', 'orgcode', 'titlecode', 'jobtitle', 'rptorg', 'rpttitle', 'status', 'created_by'
    ];

    protected $table = 'hr_organization_structure_titles';

    public function organizationStructure()
    {
        return $this->belongsTo(OrganizationStructure::class, 'orgcode', 'orgcode');
    }
}

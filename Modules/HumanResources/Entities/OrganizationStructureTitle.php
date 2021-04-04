<?php

namespace Modules\HumanResources\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;

class OrganizationStructureTitle extends MainModel
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

<?php

namespace Modules\HumanResources\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\HumanResources\Entities\HrLookup;

class HrLookupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $hrLookup = HrLookup::create([
            'mainkey' => 'hr',
            'subkey' => 'employee',
            'lkey' => 'recruitby',
            'maingrp' => 'MMF',
            'subgrp' => null,
            'grp' => null,
            'value' => null,
            'remark' => 'PT. Merpati Maintenance Facility',
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $hrLookup = HrLookup::create([
            'mainkey' => 'hr',
            'subkey' => 'employee',
            'lkey' => 'recruitby',
            'maingrp' => 'RAHU',
            'subgrp' => null,
            'grp' => null,
            'value' => null,
            'remark' => 'PT. RAHU',
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}

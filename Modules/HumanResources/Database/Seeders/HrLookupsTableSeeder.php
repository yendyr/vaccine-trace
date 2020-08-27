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

        $religions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'];
        foreach ($religions as $religion) {
            $hrLookup = HrLookup::create([
                'mainkey' => 'hr',
                'subkey' => 'employee',
                'lkey' => 'religion',
                'maingrp' => $religion,
                'subgrp' => null,
                'grp' => null,
                'value' => null,
                'remark' => $religion,
                'owned_by' => 0,
                'status' => 1,
                'uuid' => Str::uuid(),
            ]);
        }

        $maritalstatuses = ['Menikah', 'Lajang', 'Duda', 'Janda'];
        foreach ($maritalstatuses as $maritalstatus) {
            $hrLookup = HrLookup::create([
                'mainkey' => 'hr',
                'subkey' => 'employee',
                'lkey' => 'maritalstatus',
                'maingrp' => $maritalstatus[0],
                'subgrp' => null,
                'grp' => null,
                'value' => null,
                'remark' => $maritalstatus,
                'owned_by' => 0,
                'status' => 1,
                'uuid' => Str::uuid(),
            ]);
        }

        $bloodtypes = ['O', 'A', 'B', 'AB'];
        foreach ($bloodtypes as $bloodtype) {
            $hrLookup = HrLookup::create([
                'mainkey' => 'hr',
                'subkey' => 'employee',
                'lkey' => 'bloodtype',
                'maingrp' => $bloodtype,
                'subgrp' => null,
                'grp' => null,
                'value' => null,
                'remark' => $bloodtype,
                'owned_by' => 0,
                'status' => 1,
                'uuid' => Str::uuid(),
            ]);
        }
    }
}

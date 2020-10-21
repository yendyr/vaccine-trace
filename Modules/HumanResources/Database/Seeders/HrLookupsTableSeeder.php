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

        $orglevels = ['Direksi', 'General', 'Divisi', 'Bagian', 'Seksi', 'Regu', 'Grup'];
        foreach ($orglevels as $i => $orglevel) {
            $hrLookup = HrLookup::create([
                'mainkey' => 'hr',
                'subkey' => 'org-structure',
                'lkey' => 'orglevel',
                'maingrp' => ($i+1),
                'subgrp' => null,
                'grp' => null,
                'value' => null,
                'remark' => $orglevel,
                'owned_by' => 0,
                'status' => 1,
                'uuid' => Str::uuid(),
            ]);
        }

        $titlecodes = ['Kepala', 'Wakil Kepala', 'Anggota', 'Staff', 'Operator'];
        foreach ($titlecodes as $i => $titlecode) {
            $hrLookup = HrLookup::create([
                'mainkey' => 'hr',
                'subkey' => 'org-structure-title',
                'lkey' => 'titlecode',
                'maingrp' => ($i+1),
                'subgrp' => null,
                'grp' => null,
                'value' => null,
                'remark' => $titlecode,
                'owned_by' => 0,
                'status' => 1,
                'uuid' => Str::uuid(),
            ]);
        }

        $edulevels = ['S3', 'S2', 'S1', 'D3', 'SMA', 'SMP', 'SD'];
        foreach ($edulevels as $i => $edulevel) {
            $hrLookup = HrLookup::create([
                'mainkey' => 'hr',
                'subkey' => 'education',
                'lkey' => 'edulvl',
                'maingrp' => $edulevel,
                'subgrp' => null,
                'grp' => null,
                'value' => null,
                'remark' => $edulevel,
                'owned_by' => 0,
                'status' => 1,
                'uuid' => Str::uuid(),
            ]);
        }

        $relationships = ['Ayah', 'Ibu', 'Anak', 'Adik', 'Kakak', 'Suami', 'Istri', 'Mertua'];
        foreach ($relationships as $i => $relationship) {
            $hrLookup = HrLookup::create([
                'mainkey' => 'hr',
                'subkey' => 'family',
                'lkey' => 'relationship',
                'maingrp' => (0 . ($i+1)),
                'subgrp' => null,
                'grp' => null,
                'value' => null,
                'remark' => $relationship,
                'owned_by' => 0,
                'status' => 1,
                'uuid' => Str::uuid(),
            ]);
        }

        $relationships = ['Pelajar', 'Wiraswasta', 'Pegawai Negeri'];
        foreach ($relationships as $i => $relationship) {
            $hrLookup = HrLookup::create([
                'mainkey' => 'hr',
                'subkey' => 'family',
                'lkey' => 'job',
                'maingrp' => (0 . ($i+1)),
                'subgrp' => null,
                'grp' => null,
                'value' => null,
                'remark' => $relationship,
                'owned_by' => 0,
                'status' => 1,
                'uuid' => Str::uuid(),
            ]);
        }

        $attdtypes = ['Masuk kerja', 'Pulang kerja', 'Ijin Keluar', 'Ijin Masuk', 'Masuk lembur', 'Keluar lembur'];
        foreach ($attdtypes as $i => $attdtype) {
            $hrLookup = HrLookup::create([
                'mainkey' => 'hr',
                'subkey' => 'attendance',
                'lkey' => 'attdtype',
                'maingrp' => (0 . ($i+1)),
                'subgrp' => null,
                'grp' => null,
                'value' => null,
                'remark' => $attdtype,
                'owned_by' => 0,
                'status' => 1,
                'uuid' => Str::uuid(),
            ]);
        }

        $cutis = ['Cuti pribadi', 'Cuti ditetapkan'];
        foreach ($cutis as $i => $cuti) {
            $hrLookup = HrLookup::create([
                'mainkey' => 'hr',
                'subkey' => 'leave-quota',
                'lkey' => 'quotacode',
                'maingrp' => (0 . ($i+1)),
                'subgrp' => null,
                'grp' => null,
                'value' => null,
                'remark' => $cuti,
                'owned_by' => 0,
                'status' => 1,
                'uuid' => Str::uuid(),
            ]);
        }
    }
}

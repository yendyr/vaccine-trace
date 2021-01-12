<?php

namespace Modules\GeneralSetting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\GeneralSetting\Entities\Company;
use Illuminate\Support\Str;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $company = Company::create([
            'name' => 'PT. Rahu Arta Mandiri',
            'code' => 'RAM',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $company = Company::create([
            'name' => 'PT. Sarana Mendulang Arta',
            'code' => 'Smart',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $company = Company::create([
            'name' => 'Boeing International',
            'code' => 'BI',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $company = Company::create([
            'name' => 'Airbus France',
            'code' => 'AF',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}

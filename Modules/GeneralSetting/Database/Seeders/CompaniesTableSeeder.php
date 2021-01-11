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
            'company_name' => 'PT. Rahu Arta Mandiri',
            'code' => 'RAM',
            'email' => 'company1@gmail.com',
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $company = Company::create([
            'company_name' => 'PT. Sarana Mendulang Arta',
            'code' => 'Smart',
            'email' => 'company2@gmail.com',
            'owned_by' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}

<?php

namespace Modules\GeneralSetting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\GeneralSetting\Entities\CompanyDetailContact;
use Illuminate\Support\Str;

class CompanyDetailContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        CompanyDetailContact::create([
            'company_id' => 4,
            'label' => 'Primary Contact',
            'name' => 'Customer Service',
            'email' => 'cs@airbus.fr',
            'mobile_number' => '+33 849816581',
            'office_number' => '+47 651649684',
            'fax_number' => '+55 6516958168',
            'other_number' => '+55 8798765',
            'website' => 'https://airbus.fr',
            'fax_number' => '+55 6516958168',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);

        CompanyDetailContact::create([
            'company_id' => 4,
            'label' => 'US Branch Office',
            'name' => 'Customer Service',
            'email' => 'cs@airbus.com',
            'mobile_number' => '+33 849816581',
            'office_number' => '+47 651649684',
            'fax_number' => '+55 6516958168',
            'other_number' => '+55 8798765',
            'website' => 'https://www.airbus.com',
            'fax_number' => '+55 6516958168',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}

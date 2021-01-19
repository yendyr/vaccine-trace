<?php

namespace Modules\GeneralSetting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\GeneralSetting\Entities\CompanyDetailBank;
use Illuminate\Support\Str;

class CompanyDetailBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        CompanyDetailBank::create([
            'company_id' => 4,
            'label' => 'Primary Account',
            'bank_name' => 'BCA',
            'bank_branch' => 'Jakarta',
            'account_holder_name' => 'PT. Sarana Mendulang Arta',
            'account_number' => '564684765465',
            'swift_code' => 'ns9f8g7ns9rgt8ny',
            'chart_of_account_id' => '1',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);

        CompanyDetailBank::create([
            'company_id' => 4,
            'label' => 'Backup',
            'bank_name' => 'Mandiri',
            'bank_branch' => 'Surabaya',
            'account_holder_name' => 'Airbus France, Pte, Ltd',
            'account_number' => '564684765465',
            'swift_code' => 'ns9f8g7ns9rgt8ny',
            'chart_of_account_id' => '3',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);

        CompanyDetailBank::create([
            'company_id' => 4,
            'label' => 'Treassury',
            'bank_name' => 'BRI',
            'bank_branch' => 'Manado',
            'account_holder_name' => 'Boeing, Pte, Ltd',
            'account_number' => '4315979',
            'swift_code' => 'ns9f8g7ns9rgt8ny',
            'chart_of_account_id' => '5',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}

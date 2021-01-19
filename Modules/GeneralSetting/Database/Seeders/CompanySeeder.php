<?php

namespace Modules\GeneralSetting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\GeneralSetting\Entities\Company;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
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
            'gst_number' => '99.4877.AXXED-HDGTEHS',
            'npwp_number' => '01.855.081.4-412.000',
            'description' => 'one of biggest aviation industry supplier and manufacturer, part of global supply chain',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $company = Company::create([
            'name' => 'PT. Sarana Mendulang Arta',
            'code' => 'Smart',
            'gst_number' => '99.4877.AXXED-HDGTEHS',
            'npwp_number' => '01.855.081.4-412.000',
            'description' => 'one of biggest aviation industry supplier and manufacturer, part of global supply chain',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $company = Company::create([
            'name' => 'Boeing International, Pte, Ltd',
            'code' => 'BI',
            'gst_number' => '99.4877.AXXED-HDGTEHS',
            'npwp_number' => '01.855.081.4-412.000',
            'description' => 'one of biggest aviation industry supplier and manufacturer, part of global supply chain',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $company = Company::create([
            'name' => 'Airbus France, Pte, Ltd',
            'code' => 'AF',
            'gst_number' => '99.4877.AXXED-HDGTEHS',
            'npwp_number' => '01.855.081.4-412.000',
            'description' => 'one of biggest aviation industry supplier and manufacturer, part of global supply chain',
            'account_receivable_coa_id' => 2,
            'sales_discount_coa_id' => 4,
            'account_payable_coa_id' => 6,
            'purchase_discount_coa_id' => 8,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}

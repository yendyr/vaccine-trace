<?php

namespace Modules\Accounting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Accounting\Entities\ChartOfAccount;
use Illuminate\Support\Str;

class ChartOfAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $ChartOfAccount = ChartOfAccount::create([
            'name' => 'Cash and Bank',
            'code' => '1111',
            'chart_of_account_class_id' => 1,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccount = ChartOfAccount::create([
            'name' => 'Account Receivable',
            'code' => '1112',
            'chart_of_account_class_id' => 1,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccount = ChartOfAccount::create([
            'name' => 'Down Payment',
            'code' => '2222',
            'chart_of_account_class_id' => 1,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccount = ChartOfAccount::create([
            'name' => 'Debt',
            'code' => '2224',
            'chart_of_account_class_id' => 2,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccount = ChartOfAccount::create([
            'name' => 'Equity',
            'code' => '5555',
            'chart_of_account_class_id' => 3,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccount = ChartOfAccount::create([
            'name' => 'Prive',
            'code' => '5552',
            'chart_of_account_class_id' => 3,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccount = ChartOfAccount::create([
            'name' => 'Profit and Loss',
            'code' => '7779',
            'chart_of_account_class_id' => 3,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccount = ChartOfAccount::create([
            'name' => 'Operating Revenue',
            'code' => '6664',
            'chart_of_account_class_id' => 4,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccount = ChartOfAccount::create([
            'name' => 'Other Revenue',
            'code' => '4446',
            'chart_of_account_class_id' => 4,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccount = ChartOfAccount::create([
            'name' => 'Cost of Good Sales',
            'code' => '8888',
            'chart_of_account_class_id' => 5,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccount = ChartOfAccount::create([
            'name' => 'Operational Cost',
            'code' => '8887',
            'chart_of_account_class_id' => 5,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccount = ChartOfAccount::create([
            'name' => 'Other Cost',
            'code' => '8889',
            'chart_of_account_class_id' => 5,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccount = ChartOfAccount::create([
            'name' => 'Sales',
            'code' => '2226',
            'chart_of_account_class_id' => 2,
            'parent_id' => 2,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccount = ChartOfAccount::create([
            'name' => 'Service',
            'code' => '2227',
            'chart_of_account_class_id' => 2,
            'parent_id' => 2,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccount = ChartOfAccount::create([
            'name' => 'Employee Debt',
            'code' => '2221',
            'chart_of_account_class_id' => 2,
            'parent_id' => 4,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccount = ChartOfAccount::create([
            'name' => '3rd Party Debt',
            'code' => '2229',
            'chart_of_account_class_id' => 2,
            'parent_id' => 4,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}

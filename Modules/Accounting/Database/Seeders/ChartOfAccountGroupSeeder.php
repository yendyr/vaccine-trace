<?php

namespace Modules\Accounting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Accounting\Entities\ChartOfAccountGroup;
use Illuminate\Support\Str;

class ChartOfAccountGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $ChartOfAccountGroup = ChartOfAccountGroup::create([
            'name' => 'Cash and Bank',
            'code' => 'CB',
            'chart_of_account_class_id' => 1,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccountGroup = ChartOfAccountGroup::create([
            'name' => 'Account Receivable',
            'code' => 'AR',
            'chart_of_account_class_id' => 1,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccountGroup = ChartOfAccountGroup::create([
            'name' => 'Down Payment',
            'code' => 'DP',
            'chart_of_account_class_id' => 1,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccountGroup = ChartOfAccountGroup::create([
            'name' => 'Debt',
            'code' => 'DB',
            'chart_of_account_class_id' => 2,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccountGroup = ChartOfAccountGroup::create([
            'name' => 'Equity',
            'code' => 'EQ',
            'chart_of_account_class_id' => 3,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccountGroup = ChartOfAccountGroup::create([
            'name' => 'Prive',
            'code' => 'PR',
            'chart_of_account_class_id' => 3,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccountGroup = ChartOfAccountGroup::create([
            'name' => 'Profit and Loss',
            'code' => 'PL',
            'chart_of_account_class_id' => 3,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccountGroup = ChartOfAccountGroup::create([
            'name' => 'Operating Revenue',
            'code' => 'RV',
            'chart_of_account_class_id' => 4,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccountGroup = ChartOfAccountGroup::create([
            'name' => 'Other Revenue',
            'code' => 'OR',
            'chart_of_account_class_id' => 4,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccountGroup = ChartOfAccountGroup::create([
            'name' => 'Cost of Good Sales',
            'code' => 'COGS',
            'chart_of_account_class_id' => 5,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccountGroup = ChartOfAccountGroup::create([
            'name' => 'Operational Cost',
            'code' => 'OC',
            'chart_of_account_class_id' => 5,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccountGroup = ChartOfAccountGroup::create([
            'name' => 'Other Cost',
            'code' => 'OTC',
            'chart_of_account_class_id' => 5,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccountGroup = ChartOfAccountGroup::create([
            'name' => 'Sales',
            'code' => 'SLS',
            'chart_of_account_class_id' => 2,
            'parent_id' => 2,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccountGroup = ChartOfAccountGroup::create([
            'name' => 'Service',
            'code' => 'SVC',
            'chart_of_account_class_id' => 2,
            'parent_id' => 2,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccountGroup = ChartOfAccountGroup::create([
            'name' => 'Employee Debt',
            'code' => 'EDB',
            'chart_of_account_class_id' => 2,
            'parent_id' => 4,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccountGroup = ChartOfAccountGroup::create([
            'name' => '3rd Party Debt',
            'code' => 'PDB',
            'chart_of_account_class_id' => 2,
            'parent_id' => 4,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}

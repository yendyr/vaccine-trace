<?php

namespace Modules\Accounting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Accounting\Entities\ChartOfAccountClass;
use Illuminate\Support\Str;

class ChartOfAccountClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $ChartOfAccountClass = ChartOfAccountClass::create([
            'name' => 'Assets',
            'code' => 'AST',
            'position' => 'Activa',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccountClass = ChartOfAccountClass::create([
            'name' => 'Liabilities',
            'code' => 'LBL',
            'position' => 'Passiva',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccountClass = ChartOfAccountClass::create([
            'name' => 'Equity',
            'position' => 'Passiva',
            'code' => 'EQ',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccountClass = ChartOfAccountClass::create([
            'name' => 'Income',
            'position' => 'Passiva',
            'code' => 'INC',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccountClass = ChartOfAccountClass::create([
            'name' => 'Expense',
            'code' => 'EXP',
            'position' => 'Activa',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}

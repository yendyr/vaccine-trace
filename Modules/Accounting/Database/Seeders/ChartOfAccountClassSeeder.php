<?php

namespace Modules\PPC\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\PPC\Entities\ChartOfAccountClass;
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
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccountClass = ChartOfAccountClass::create([
            'name' => 'Liabilities',
            'code' => 'LBL',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccountClass = ChartOfAccountClass::create([
            'name' => 'Equity',
            'code' => 'EQ',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccountClass = ChartOfAccountClass::create([
            'name' => 'Income',
            'code' => 'INC',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ChartOfAccountClass = ChartOfAccountClass::create([
            'name' => 'Expense',
            'code' => 'EXP',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}

<?php

namespace Modules\PPC\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\PPC\Entities\TaskcardType;
use Illuminate\Support\Str;

class TaskcardTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $TaskcardType = TaskcardType::create([
            'name' => 'Inspection',
            'code' => 'INSP',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $TaskcardType = TaskcardType::create([
            'name' => 'Check',
            'code' => 'CHK',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $TaskcardType = TaskcardType::create([
            'name' => 'Visual Check',
            'code' => 'VCHK',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $TaskcardType = TaskcardType::create([
            'name' => 'Service',
            'code' => 'SVC',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}

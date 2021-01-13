<?php

namespace Modules\PPC\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\PPC\Entities\TaskcardWorkarea;
use Illuminate\Support\Str;

class TaskcardWorkareaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $TaskcardWorkarea = TaskcardWorkarea::create([
            'name' => 'AC Dist Bay',
            'code' => 'ADB',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $TaskcardWorkarea = TaskcardWorkarea::create([
            'name' => 'AC Cargo Bay',
            'code' => 'ACB',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $TaskcardWorkarea = TaskcardWorkarea::create([
            'name' => 'AC Distribution Bay',
            'code' => 'ADBY',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $TaskcardWorkarea = TaskcardWorkarea::create([
            'name' => 'AFT Cargo Compartement',
            'code' => 'AFTCC',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}

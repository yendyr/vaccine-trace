<?php

namespace Modules\PPC\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\PPC\Entities\TaskcardAccess;
use Illuminate\Support\Str;

class TaskcardAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $TaskcardAccess = TaskcardAccess::create([
            'name' => '291AT',
            'code' => '291AT',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $TaskcardAccess = TaskcardAccess::create([
            'name' => '292AT',
            'code' => '292AT',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $TaskcardAccess = TaskcardAccess::create([
            'name' => '293AT',
            'code' => '293AT',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $TaskcardAccess = TaskcardAccess::create([
            'name' => '294AT',
            'code' => '294AT',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}

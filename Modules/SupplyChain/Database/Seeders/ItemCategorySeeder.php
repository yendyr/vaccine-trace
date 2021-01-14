<?php

namespace Modules\SupplyChain\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\SupplyChain\Entities\ItemCategory;
use Illuminate\Support\Str;

class ItemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $ItemCategory = ItemCategory::create([
            'name' => 'Raw Material',
            'code' => 'RW',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ItemCategory = ItemCategory::create([
            'name' => 'Tools',
            'code' => 'TL',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $ItemCategory = ItemCategory::create([
            'name' => 'Service',
            'code' => 'SV',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);        
    }
}

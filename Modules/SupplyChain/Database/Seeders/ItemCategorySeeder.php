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

        ItemCategory::create([
            'name' => 'Component',
            'code' => 'CMP',
            'uuid' => Str::uuid(),
        ]);
        ItemCategory::create([
            'name' => 'Raw Material',
            'code' => 'RW',
            'uuid' => Str::uuid(),
        ]);
        ItemCategory::create([
            'name' => 'Tools',
            'code' => 'TL',
            'uuid' => Str::uuid(),
        ]);
        ItemCategory::create([
            'name' => 'Service',
            'code' => 'SV',
            'uuid' => Str::uuid(),
        ]);        
        ItemCategory::create([
            'name' => 'Facility',
            'code' => 'FS',
            'uuid' => Str::uuid(),
        ]);        
    }
}

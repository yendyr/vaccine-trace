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
            'sales_coa_id' => '1',
            'inventory_coa_id' => '3',
            'cost_coa_id' => '5',
            'inventory_adjustment_coa_id' => '7',
            'status' => '1',
            'uuid' => Str::uuid(),
        ]);
        ItemCategory::create([
            'name' => 'Raw Material',
            'code' => 'RW',
            'sales_coa_id' => '1',
            'inventory_coa_id' => '3',
            'cost_coa_id' => '5',
            'inventory_adjustment_coa_id' => '7',
            'status' => '1',
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

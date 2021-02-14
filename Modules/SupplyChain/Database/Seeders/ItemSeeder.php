<?php

namespace Modules\SupplyChain\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\SupplyChain\Entities\Item;
use Illuminate\Support\Str;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Item::create([
            'name' => 'Jet Engine',
            'code' => 'PT-67',
            'category_id' => 1,
            'primary_unit_id' => 25,
            'manufacturer_id' => 3,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Item::create([
            'name' => 'Landing Gear',
            'code' => '8447-2005',
            'category_id' => 1,
            'primary_unit_id' => 25,
            'manufacturer_id' => 3,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]); 
        Item::create([
            'name' => 'Propeller',
            'code' => '25-766',
            'category_id' => 1,
            'primary_unit_id' => 25,
            'manufacturer_id' => 3,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]); 
        Item::create([
            'name' => 'Fire Extingusher',
            'code' => '276-A',
            'category_id' => 1,
            'primary_unit_id' => 25,
            'manufacturer_id' => 3,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]); 
        Item::create([
            'name' => 'Main Bolt',
            'code' => '45-554',
            'category_id' => 2,
            'primary_unit_id' => 25,
            'manufacturer_id' => 3,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);    
    }
}
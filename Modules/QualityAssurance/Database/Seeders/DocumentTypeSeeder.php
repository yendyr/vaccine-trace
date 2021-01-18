<?php

namespace Modules\QualityAssurance\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\QualityAssurance\Entities\DocumentType;
use Illuminate\Support\Str;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $DocumentType = DocumentType::create([
            'name' => 'Aircraft Maintenance Manual',
            'code' => 'AMM',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $DocumentType = DocumentType::create([
            'name' => 'Component Maintenance Manual',
            'code' => 'CMM',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $DocumentType = DocumentType::create([
            'name' => 'Illustrated Parts Catalogue',
            'code' => 'IPC',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}

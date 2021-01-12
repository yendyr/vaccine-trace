<?php

namespace Modules\PPC\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\PPC\Entities\TaskcardDocumentLibrary;
use Illuminate\Support\Str;

class TaskcardDocumentLibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $TaskcardDocumentLibrary = TaskcardDocumentLibrary::create([
            'name' => 'DOC-291AT',
            'code' => 'DOC-291AT',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $TaskcardDocumentLibrary = TaskcardDocumentLibrary::create([
            'name' => 'DOC-292AT',
            'code' => 'DOC-292AT',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $TaskcardDocumentLibrary = TaskcardDocumentLibrary::create([
            'name' => 'DOC-293AT',
            'code' => 'DOC-293AT',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $TaskcardDocumentLibrary = TaskcardDocumentLibrary::create([
            'name' => 'DOC-294AT',
            'code' => 'DOC-294AT',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}

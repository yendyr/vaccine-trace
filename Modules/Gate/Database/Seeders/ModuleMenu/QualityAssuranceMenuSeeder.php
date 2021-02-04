<?php

namespace Modules\Gate\Database\Seeders\ModuleMenu;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Menu;

class QualityAssuranceMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Menu::create([
            'menu_link' => 'qualityassurance/skill',
            'menu_text' => 'Master Skill',
            'menu_route' => 'qualityassurance.skill.index',
            'menu_icon' => 'fa-bookmark',
            'menu_class' => 'Modules\QualityAssurance\Entities\Skill',
            'menu_id' => null,
            'menu_actives' => json_encode(['qualityassurance/skill', 'qualityassurance/skill/*']),
            'group' => 'Quality Assurance',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);

        Menu::create([
            'menu_link' => 'qualityassurance/engineering-level',
            'menu_text' => 'Master Engineering Leveling',
            'menu_route' => 'qualityassurance.engineering-level.index',
            'menu_icon' => 'fa-signal',
            'menu_class' => 'Modules\QualityAssurance\Entities\EngineeringLevel',
            'menu_id' => null,
            'menu_actives' => json_encode(['qualityassurance/engineering-level', 'qualityassurance/engineering-level/*']),
            'group' => 'Quality Assurance',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);

        Menu::create([
            'menu_link' => 'qualityassurance/task-release-level',
            'menu_text' => 'Master Task Release Level',
            'menu_route' => 'qualityassurance.task-release-level.index',
            'menu_icon' => 'fa-check-square',
            'menu_class' => 'Modules\QualityAssurance\Entities\TaskReleaseLevel',
            'menu_id' => null,
            'menu_actives' => json_encode(['qualityassurance/task-release-level', 'qualityassurance/task-release-level/*']),
            'group' => 'Quality Assurance',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);

        Menu::create([
            'menu_link' => 'qualityassurance/document-type',
            'menu_text' => 'Master Document Type',
            'menu_route' => 'qualityassurance.document-type.index',
            'menu_icon' => 'fa-tags',
            'menu_class' => 'Modules\QualityAssurance\Entities\DocumentType',
            'menu_id' => null,
            'menu_actives' => json_encode(['qualityassurance/document-type', 'qualityassurance/document-type/*']),
            'group' => 'Quality Assurance',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
    }
}
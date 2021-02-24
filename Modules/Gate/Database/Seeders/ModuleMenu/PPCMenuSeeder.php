<?php

namespace Modules\Gate\Database\Seeders\ModuleMenu;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Menu;

class PPCMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $menuPpcTaskcard = Menu::create([
            'menu_link' => '#',
            'menu_text' => 'Task Card',
            'menu_route' => null,
            'menu_icon' => 'fa-sitemap',
            'menu_class' => null,
            'menu_id' => null,
            'group' => 'PPC',
            'add' => 0,
            'update' => 0,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);

        Menu::create([
            'menu_link' => 'ppc/taskcard-group',
            'menu_text' => 'Master Task Card Group',
            'menu_route' => 'ppc.taskcard-group.index',
            'menu_icon' => 'fa-chain-broken',
            'menu_class' => 'Modules\PPC\Entities\TaskcardGroup',
            'menu_id' => null,
            'menu_actives' => json_encode(['ppc/taskcard-group', 'ppc/taskcard-group/*']),
            'group' => 'PPC',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuPpcTaskcard->id
        ]);

        Menu::create([
            'menu_link' => 'ppc/taskcard-type',
            'menu_text' => 'Master Task Card Type',
            'menu_route' => 'ppc.taskcard-type.index',
            'menu_icon' => 'fa-columns',
            'menu_class' => 'Modules\PPC\Entities\TaskcardType',
            'menu_id' => null,
            'menu_actives' => json_encode(['ppc/taskcard-type', 'ppc/taskcard-type/*']),
            'group' => 'PPC',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuPpcTaskcard->id
        ]);

        Menu::create([
            'menu_link' => 'ppc/taskcard-workarea',
            'menu_text' => 'Master Task Card Work Area',
            'menu_route' => 'ppc.taskcard-workarea.index',
            'menu_icon' => 'fa-yelp',
            'menu_class' => 'Modules\PPC\Entities\TaskcardWorkarea',
            'menu_id' => null,
            'menu_actives' => json_encode(['ppc/taskcard-workarea', 'ppc/taskcard-workarea/*']),
            'group' => 'PPC',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuPpcTaskcard->id
        ]);

        Menu::create([
            'menu_link' => 'ppc/taskcard-access',
            'menu_text' => 'Master Task Card Access',
            'menu_route' => 'ppc.taskcard-access.index',
            'menu_icon' => 'fa-circle-o-notch',
            'menu_class' => 'Modules\PPC\Entities\TaskcardAccess',
            'menu_id' => null,
            'menu_actives' => json_encode(['ppc/taskcard-access', 'ppc/taskcard-access/*']),
            'group' => 'PPC',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuPpcTaskcard->id
        ]);

        Menu::create([
            'menu_link' => 'ppc/taskcard-zone',
            'menu_text' => 'Master Task Card Zone',
            'menu_route' => 'ppc.taskcard-zone.index',
            'menu_icon' => 'fa-slack',
            'menu_class' => 'Modules\PPC\Entities\TaskcardZone',
            'menu_id' => null,
            'menu_actives' => json_encode(['ppc/taskcard-zone', 'ppc/taskcard-zone/*']),
            'group' => 'PPC',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuPpcTaskcard->id
        ]);

        Menu::create([
            'menu_link' => 'ppc/taskcard-document-library',
            'menu_text' => 'Master Task Card Document Library',
            'menu_route' => 'ppc.taskcard-document-library.index',
            'menu_icon' => 'fa-folder',
            'menu_class' => 'Modules\PPC\Entities\TaskcardDocumentLibrary',
            'menu_id' => null,
            'menu_actives' => json_encode(['ppc/taskcard-document-library', 'ppc/taskcard-document-library/*']),
            'group' => 'PPC',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuPpcTaskcard->id
        ]);

        Menu::create([
            'menu_link' => 'ppc/taskcard',
            'menu_text' => 'Master Task Card',
            'menu_route' => 'ppc.taskcard.index',
            'menu_icon' => 'fa-clipboard',
            'menu_class' => 'Modules\PPC\Entities\Taskcard',
            'menu_id' => null,
            'menu_actives' => json_encode(['ppc/taskcard', 'ppc/taskcard/*']),
            'group' => 'PPC',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuPpcTaskcard->id
        ]);

        Menu::create([
            'menu_link' => 'ppc/maintenance-program',
            'menu_text' => 'Maintenance Program',
            'menu_route' => 'ppc.maintenance-program.index',
            'menu_icon' => 'fa-rub',
            'menu_class' => 'Modules\PPC\Entities\MaintenanceProgram',
            'menu_id' => null,
            'menu_actives' => json_encode(['ppc/maintenance-program', 'ppc/maintenance-program/*']),
            'group' => 'PPC',
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

        $menuPpcAircraft = Menu::create([
            'menu_link' => '#',
            'menu_text' => 'Aircraft',
            'menu_route' => null,
            'menu_icon' => 'fa-plane',
            'menu_class' => null,
            'menu_id' => null,
            'group' => 'PPC',
            'add' => 0,
            'update' => 0,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);

        Menu::create([
            'menu_link' => 'ppc/aircraft-type',
            'menu_text' => 'Master Aircraft Type',
            'menu_route' => 'ppc.aircraft-type.index',
            'menu_icon' => 'fa-plane',
            'menu_class' => 'Modules\PPC\Entities\AircraftType',
            'menu_id' => null,
            'menu_actives' => json_encode(['ppc/aircraft-type', 'ppc/aircraft-type/*']),
            'group' => 'PPC',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuPpcAircraft->id
        ]);

        Menu::create([
            'menu_link' => 'ppc/aircraft-configuration-template',
            'menu_text' => 'Aircraft Configuration Template',
            'menu_route' => 'ppc.aircraft-configuration-template.index',
            'menu_icon' => 'fa-sliders',
            'menu_class' => 'Modules\PPC\Entities\AircraftConfigurationTemplate',
            'menu_id' => null,
            'menu_actives' => json_encode(['ppc/aircraft-configuration-template', 'ppc/aircraft-configuration-template/*']),
            'group' => 'PPC',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuPpcAircraft->id
        ]);

        Menu::create([
            'menu_link' => 'ppc/aircraft-configuration',
            'menu_text' => 'Owned Aircraft',
            'menu_route' => 'ppc.aircraft-configuration.index',
            'menu_icon' => 'fa-fighter-jet',
            'menu_class' => 'Modules\PPC\Entities\AircraftConfiguration',
            'menu_id' => null,
            'menu_actives' => json_encode(['ppc/aircraft-configuration', 'ppc/aircraft-configuration/*']),
            'group' => 'PPC',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $menuPpcAircraft->id
        ]);

        Menu::create([
            'menu_link' => 'ppc/item-aging-report',
            'menu_text' => 'Item/Component Aging Report',
            'menu_route' => 'ppc.item-aging-report.index',
            'menu_icon' => 'fa-clock-o',
            'menu_class' => 'Modules\PPC\Entities\ItemStockAging',
            'menu_id' => null,
            'menu_actives' => json_encode(['ppc/item-aging-report', 'ppc/item-aging-report/*']),
            'group' => 'PPC',
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
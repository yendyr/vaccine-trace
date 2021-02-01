<?php

namespace Modules\PPC\Http\Controllers;

use Modules\PPC\Entities\AircraftConfiguration;
use Modules\PPC\Entities\AircraftConfigurationDetail;
use Modules\PPC\Entities\AircraftConfigurationTemplate;
use Modules\PPC\Entities\AircraftConfigurationTemplateDetail;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Carbon;

class AircraftConfigurationController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(AircraftConfiguration::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AircraftConfiguration::with(['aircraft_type:id,name',
                                                'max_takeoff_weight_unit:id,name',
                                                'max_landing_weight_unit:id,name',
                                                'max_zero_fuel_weight_unit:id,name',
                                                'fuel_capacity_unit:id,name',
                                                'basic_empty_weight_unit:id,name',
                                                ]);
            
            return Datatables::of($data)
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<label class="label label-success">Active</label>';
                    } else{
                        return '<label class="label label-danger">Inactive</label>';
                    }
                })
                ->addColumn('creator_name', function($row){
                    return $row->creator->name ?? '-';
                })
                ->addColumn('updater_name', function($row){
                    return $row->updater->name ?? '-';
                })
                ->addColumn('action', function($row){
                    $noAuthorize = true;
                    if(Auth::user()->can('update', AircraftConfiguration::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', AircraftConfiguration::class)) {
                        $deleteable = true;
                        $deleteId = $row->id;
                        $noAuthorize = false;
                    }

                    if ($noAuthorize == false) {
                        return view('components.action-button', compact(['updateable', 'updateValue','deleteable', 'deleteId']));
                    }
                    else {
                        return '<p class="text-muted">Not Authorized</p>';
                    }
                    
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('ppc::pages.aircraft-configuration.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'registration_number' => ['required', 'max:30'],
            'serial_number' => ['required', 'max:30'],
            'aircraft_type_id' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        if ($request->manufactured_date) {
            $manufactured_date = Carbon::createFromFormat('m/d/Y', $request->manufactured_date)->format('Y-m-d');
        }
        else {
            $manufactured_date = null;
        }

        if ($request->received_date) {
            $received_date = Carbon::createFromFormat('m/d/Y', $request->received_date)->format('Y-m-d');
        }
        else {
            $received_date = null;
        }

        if ($request->duplicated_from) {
            $detail_source = AircraftConfigurationTemplate::where('id', $request->duplicated_from)
                                                ->with('template_details')
                                                ->first();

            DB::beginTransaction();
            $AircraftConfiguration = AircraftConfiguration::create([
                'uuid' =>  Str::uuid(),
                'code' => $request->code,
                'name' => $request->name,
                'registration_number' => $request->registration_number,
                'serial_number' => $request->serial_number,
                'manufactured_date' => $manufactured_date,
                'received_date' => $received_date,
                'description' => $request->description,
                'aircraft_type_id' => $request->aircraft_type_id,

                'max_takeoff_weight' => $request->max_takeoff_weight,
                'max_takeoff_weight_unit_id' => $request->max_takeoff_weight_unit_id,
                'max_landing_weight' => $request->max_landing_weight,
                'max_landing_weight_unit_id' => $request->max_landing_weight_unit_id,
                'max_zero_fuel_weight' => $request->max_zero_fuel_weight,
                'max_zero_fuel_weight_unit_id' => $request->max_zero_fuel_weight_unit_id,

                'fuel_capacity' => $request->fuel_capacity,
                'fuel_capacity_unit_id' => $request->fuel_capacity_unit_id,
                'basic_empty_weight' => $request->basic_empty_weight,
                'basic_empty_weight_unit_id' => $request->basic_empty_weight_unit_id,
    
                'owned_by' => $request->user()->company_id,
                'status' => $status,
                'created_by' => $request->user()->id,
            ]);
                
            foreach ($detail_source->template_details as $template_detail) {
                $newDetail = AircraftConfigurationDetail::create([
                    'uuid' =>  Str::uuid(),

                    'coding' => $template_detail->coding,
                    'aircraft_configuration_id' => $AircraftConfiguration->id,
                    'item_id' => $template_detail->item_id,
                    'alias_name' => $template_detail->alias_name,
                    'description' => $template_detail->description,
                    'highlight' => $template_detail->highlight,
                    'parent_coding' => $template_detail->parent_coding,
        
                    'owned_by' => $request->user()->company_id,
                    'status' => $template_detail->status,
                    'created_by' => $request->user()->id,
                ]);
                $newDetail->update([
                    'coding' => $newDetail->aircraft_configuration_id . '-' . Str::after($newDetail->coding, '-')
                ]);
                if ($newDetail->parent_coding) {
                    $newDetail->update([
                        'parent_coding' => $newDetail->aircraft_configuration_id . '-' . Str::after($newDetail->parent_coding, '-')
                    ]);
                }
            }
            DB::commit();

            return response()->json(['success' => 'Aircraft Configuration Data has been Saved',
                                    'id' => $AircraftConfiguration->id]);
        }
        else {
            $AircraftConfiguration = AircraftConfiguration::create([
                'uuid' =>  Str::uuid(),
                'code' => $request->code,
                'name' => $request->name,
                'registration_number' => $request->registration_number,
                'serial_number' => $request->serial_number,
                'manufactured_date' => $manufactured_date,
                'received_date' => $received_date,
                'description' => $request->description,
                'aircraft_type_id' => $request->aircraft_type_id,

                'max_takeoff_weight' => $request->max_takeoff_weight,
                'max_takeoff_weight_unit_id' => $request->max_takeoff_weight_unit_id,
                'max_landing_weight' => $request->max_landing_weight,
                'max_landing_weight_unit_id' => $request->max_landing_weight_unit_id,
                'max_zero_fuel_weight' => $request->max_zero_fuel_weight,
                'max_zero_fuel_weight_unit_id' => $request->max_zero_fuel_weight_unit_id,

                'fuel_capacity' => $request->fuel_capacity,
                'fuel_capacity_unit_id' => $request->fuel_capacity_unit_id,
                'basic_empty_weight' => $request->basic_empty_weight,
                'basic_empty_weight_unit_id' => $request->basic_empty_weight_unit_id,
    
                'owned_by' => $request->user()->company_id,
                'status' => $status,
                'created_by' => $request->user()->id,
            ]);
    
            return response()->json(['success' => 'Aircraft Configuration Data has been Saved',
                                    'id' => $AircraftConfiguration->id]);
        }
    }

    public function show(AircraftConfiguration $AircraftConfiguration)
    {
        return view('ppc::pages.aircraft-configuration.show', compact('AircraftConfiguration'));
    }

    public function edit(AircraftConfiguration $AircraftConfiguration)
    {
        return view('ppc::pages.aircraft-configuration.edit', compact('AircraftConfiguration'));
    }

    public function update(Request $request, AircraftConfiguration $AircraftConfiguration)
    {
        $request->validate([
            'registration_number' => ['required', 'max:30'],
            'serial_number' => ['required', 'max:30'],
            'aircraft_type_id' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        if ($request->manufactured_date) {
            $manufactured_date = Carbon::createFromFormat('m/d/Y', $request->manufactured_date)->format('Y-m-d');
        }
        else {
            $manufactured_date = null;
        }

        if ($request->received_date) {
            $received_date = Carbon::createFromFormat('m/d/Y', $request->received_date)->format('Y-m-d');
        }
        else {
            $received_date = null;
        }

        $currentRow = AircraftConfiguration::where('id', $AircraftConfiguration->id)->first();
        if ( $currentRow->code == $request->code) {
            $currentRow
                ->update([
                    'name' => $request->name,
                    'registration_number' => $request->registration_number,
                    'serial_number' => $request->serial_number,
                    'manufactured_date' => $manufactured_date,
                    'received_date' => $received_date,
                    'description' => $request->description,
                    'aircraft_type_id' => $request->aircraft_type_id,

                    'max_takeoff_weight' => $request->max_takeoff_weight,
                    'max_takeoff_weight_unit_id' => $request->max_takeoff_weight_unit_id,
                    'max_landing_weight' => $request->max_landing_weight,
                    'max_landing_weight_unit_id' => $request->max_landing_weight_unit_id,
                    'max_zero_fuel_weight' => $request->max_zero_fuel_weight,
                    'max_zero_fuel_weight_unit_id' => $request->max_zero_fuel_weight_unit_id,

                    'fuel_capacity' => $request->fuel_capacity,
                    'fuel_capacity_unit_id' => $request->fuel_capacity_unit_id,
                    'basic_empty_weight' => $request->basic_empty_weight,
                    'basic_empty_weight_unit_id' => $request->basic_empty_weight_unit_id,

                    'status' => $status,
                    'updated_by' => Auth::user()->id,
            ]);
        }
        else {
            $currentRow
                ->update([
                    'code' => $request->code,
                    'registration_number' => $request->registration_number,
                    'serial_number' => $request->serial_number,
                    'manufactured_date' => $manufactured_date,
                    'received_date' => $received_date,
                    'description' => $request->description,
                    'aircraft_type_id' => $request->aircraft_type_id,

                    'max_takeoff_weight' => $request->max_takeoff_weight,
                    'max_takeoff_weight_unit_id' => $request->max_takeoff_weight_unit_id,
                    'max_landing_weight' => $request->max_landing_weight,
                    'max_landing_weight_unit_id' => $request->max_landing_weight_unit_id,
                    'max_zero_fuel_weight' => $request->max_zero_fuel_weight,
                    'max_zero_fuel_weight_unit_id' => $request->max_zero_fuel_weight_unit_id,

                    'fuel_capacity' => $request->fuel_capacity,
                    'fuel_capacity_unit_id' => $request->fuel_capacity_unit_id,
                    'basic_empty_weight' => $request->basic_empty_weight,
                    'basic_empty_weight_unit_id' => $request->basic_empty_weight_unit_id,
                    
                    'status' => $status,
                    'updated_by' => Auth::user()->id,
            ]);
        }
        return response()->json(['success' => 'Aircraft Configuration Data has been Updated',
                                'id' => $AircraftConfiguration->id]);
    }

    public function destroy(AircraftConfiguration $AircraftConfiguration)
    {
        $currentRow = AircraftConfiguration::where('id', $AircraftConfiguration->id)->first();
        $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        AircraftConfiguration::destroy($AircraftConfiguration->id);
        return response()->json(['success' => 'Aircraft Configuration Data has been Deleted']);
    }
}
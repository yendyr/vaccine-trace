<?php

namespace Modules\PPC\Http\Controllers;

use Modules\PPC\Entities\AircraftConfiguration;
use Modules\PPC\Entities\AircraftConfigurationDetail;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;

class AircraftConfigurationDetailController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(AircraftConfigurationDetail::class, 'configuration_detail');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $aircraft_configuration_id = $request->id;
        
        $data = AircraftConfigurationDetail::where('aircraft_configuration_id', $aircraft_configuration_id)
                                                ->with(['item:id,code,name',
                                                        'item_group:id,item_id,alias_name,coding,parent_coding'])
                                                ->orderBy('created_at','asc')
                                                ->get();
                                                
        $AircraftConfiguration = AircraftConfiguration::where('id', $aircraft_configuration_id)->first();

        if ($AircraftConfiguration->approvals()->count() == 0) {
            return Datatables::of($data)
            ->addColumn('status', function($row){
                if ($row->status == 1){
                    return '<label class="label label-success">Active</label>';
                } else{
                    return '<label class="label label-danger">Inactive</label>';
                }
            })
            ->addColumn('highlighted', function($row){
                if ($row->highlight == 1){
                    return '<label class="label label-primary">Yes</label>';
                } else{
                    return '<label class="label label-danger">No</label>';
                }
            })
            ->addColumn('parent_item_code', function($row){
                return $row->item_group->item->code ?? '-';
            })
            ->addColumn('parent_item_name', function($row){
                if ($row->item_group) {
                    return $row->item_group->item->name . ' | ' . $row->item_group->alias_name;
                }
                else {
                    return '-';
                }
                
            })
            ->addColumn('creator_name', function($row){
                return $row->creator->name ?? '-';
            })
            ->addColumn('updater_name', function($row){
                return $row->updater->name ?? '-';
            })
            ->addColumn('action', function($row) {
                $noAuthorize = true;

                if(Auth::user()->can('update', AircraftConfigurationDetail::class)) {
                    $updateable = 'button';
                    $updateValue = $row->id;
                    $noAuthorize = false;
                }
                if(Auth::user()->can('delete', AircraftConfigurationDetail::class)) {
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
        else {
            return Datatables::of($data)
            ->addColumn('status', function($row){
                if ($row->status == 1){
                    return '<label class="label label-success">Active</label>';
                } else{
                    return '<label class="label label-danger">Inactive</label>';
                }
            })
            ->addColumn('highlighted', function($row){
                if ($row->highlight == 1){
                    return '<label class="label label-primary">Yes</label>';
                } else{
                    return '<label class="label label-danger">No</label>';
                }
            })
            ->addColumn('parent_item_code', function($row){
                return $row->item_group->item->code ?? '-';
            })
            ->addColumn('parent_item_name', function($row){
                if ($row->item_group) {
                    return $row->item_group->item->name . ' | ' . $row->item_group->alias_name;
                }
                else {
                    return '-';
                }
                
            })
            ->addColumn('creator_name', function($row){
                return $row->creator->name ?? '-';
            })
            ->addColumn('updater_name', function($row){
                return $row->updater->name ?? '-';
            })
            ->addColumn('action', function($row) {
                return '<p class="text-muted">Already Approved</p>';
            })
            ->escapeColumns([])
            ->make(true);
        }

        
        
    }

    public function tree(Request $request)
    {
        $aircraft_configuration_id = $request->id;
        
        $datas = AircraftConfigurationDetail::where('aircraft_configuration_id', $aircraft_configuration_id)
                                                ->with(['item:id,code,name',
                                                        'item_group:id,item_id,alias_name'])
                                                ->where('aircraft_configuration_details.status', 1)
                                                ->orderBy('created_at','asc')
                                                ->get();
        $response = [];
        foreach($datas as $data) {
            if ($data->parent_coding) {
                $parent = $data->parent_coding;
            }
            else {
                $parent = '#';
            }

            $response[] = [
                "id" => $data->coding,
                "parent" => $parent,
                "text" => 'P/N: <strong>' . $data->item->code . '</strong> | Item Name: <strong>' . $data->item->name . '</strong> | Alias Name: <strong>' . $data->alias_name . '</strong>'
            ];
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $AircraftConfiguration = AircraftConfiguration::where('id', $request->aircraft_configuration_id)->first();

        if ($AircraftConfiguration->approvals()->count() == 0) {
            $request->validate([
                'item_id' => ['required'],
            ]);
    
            if ($request->status) {
                $status = 1;
            } 
            else {
                $status = 0;
            }
    
            if ($request->highlight) {
                $highlight = 1;
            } 
            else {
                $highlight = 0;
            }
    
            $initial_start_date = $request->initial_start_date;
    
            DB::beginTransaction();
            $AircraftConfigurationDetail = AircraftConfigurationDetail::create([
                'uuid' =>  Str::uuid(),
    
                'aircraft_configuration_id' => $request->aircraft_configuration_id,
                'item_id' => $request->item_id,
                'serial_number' => $request->serial_number,
                'alias_name' => $request->alias_name,
                'highlight' => $highlight,
                'description' => $request->description,
                'parent_coding' => $request->parent_coding,
    
                'initial_flight_hour' => $request->initial_flight_hour,
                'initial_flight_cycle' => $request->initial_flight_cycle,
                'initial_flight_event' => $request->initial_flight_event,
                'initial_start_date' => $initial_start_date,
    
                'owned_by' => $request->user()->company_id,
                'status' => $status,
                'created_by' => $request->user()->id,
            ]);
            $AircraftConfigurationDetail->update([
                'coding' => $AircraftConfigurationDetail->aircraft_configuration_id . '-' . $AircraftConfigurationDetail->id,
            ]);
            DB::commit();
    
            return response()->json(['success' => 'Item/Component Data has been Added']);
        }
        else {
            return response()->json(['error' => "This Aircraft Configuration and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function show(AircraftConfigurationDetail $AircraftConfigurationDetail)
    {
        return view('ppc::pages.aircraft-configuration-detail.show', compact('AircraftConfigurationDetail'));
    }

    public function update(Request $request, AircraftConfigurationDetail $ConfigurationDetail)
    {
        $currentRow = AircraftConfigurationDetail::where('id', $ConfigurationDetail->id)
                                                ->with('all_childs')
                                                ->first();

        $AircraftConfiguration = AircraftConfiguration::where('id', $currentRow->aircraft_configuration_id)->first();

        if ($AircraftConfiguration->approvals()->count() == 0) {
            $request->validate([
                'item_id' => ['required'],
            ]);
    
            if ($request->status) {
                $status = 1; 
                
                if ($currentRow->parent_coding != null) {
                    if ($currentRow->item_group->status == 0) {
                        return response()->json(['error' => "This Item's Parent Status Still Deactivated, so You Can't Activate this Item"]);
                    }
                }
            } 
            else {
                $status = 0;
            }
    
            if ($request->highlight) {
                $highlight = 1;
            } 
            else {
                $highlight = 0;
            }
    
            $initial_start_date = $request->initial_start_date;
            
            if ($request->parent_coding == $currentRow->coding) {
                $parent_coding = null;
            }
            else {
                $parent_coding = $request->parent_coding;
            }
    
            DB::beginTransaction();
            $currentRow
                ->update([
                    'item_id' => $request->item_id,
                    'alias_name' => $request->alias_name,
                    'serial_number' => $request->serial_number,
                    'highlight' => $highlight,
                    'description' => $request->description,
                    'parent_coding' => $parent_coding,
    
                    'initial_flight_hour' => $request->initial_flight_hour,
                    'initial_flight_cycle' => $request->initial_flight_cycle,
                    'initial_flight_event' => $request->initial_flight_event,
                    'initial_start_date' => $initial_start_date,
    
                    'status' => $status,
                    'updated_by' => Auth::user()->id,
            ]);
            if (sizeof($currentRow->all_childs) > 0) {
                Self::updateChilds($currentRow, $status);
            }
            DB::commit();
            
            return response()->json(['success' => 'Item/Component Data has been Updated']);
        }
        else {
            return response()->json(['error' => "This Aircraft Configuration and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function updateChilds($currentRow, $status)
    {
        foreach($currentRow->all_childs as $childRow) {
            $childRow
                ->update([
                    'status' => $status,
                    'updated_by' => Auth::user()->id,
                ]);
            if (sizeof($childRow->all_childs) > 0) {
                Self::updateChilds($childRow, $status);
            }
        }
    }

    public function destroy(AircraftConfigurationDetail $ConfigurationDetail)
    {
        $currentRow = AircraftConfigurationDetail::where('id', $ConfigurationDetail->id)->first();
        $AircraftConfiguration = AircraftConfiguration::where('id', $currentRow->aircraft_configuration_id)->first();

        if ($AircraftConfiguration->approvals()->count() == 0) {
            $currentRow
                    ->update([
                        'deleted_by' => Auth::user()->id,
                    ]);

            AircraftConfigurationDetail::destroy($ConfigurationDetail->id);
            return response()->json(['success' => 'Item/Component Data has been Deleted']);
        }
        else {
            return response()->json(['error' => "This Aircraft Configuration and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function select2Parent(Request $request)
    {
        $search = $request->term;
        $aircraft_configuration_id = $request->aircraft_configuration_id;

        $query = DB::table('aircraft_configuration_details')
                    ->leftJoin('items', 'aircraft_configuration_details.item_id', '=', 'items.id')
                    ->where('aircraft_configuration_details.aircraft_configuration_id', $aircraft_configuration_id)
                    ->where('aircraft_configuration_details.status', '1')
                    ->select('aircraft_configuration_details.id', 'aircraft_configuration_details.coding', 'aircraft_configuration_details.alias_name', 'items.code', 'items.name');

        if($search != ''){
            $query = $query->where('items.name', 'like', '%' .$search. '%')
                            ->orWhere('items.code', 'like', '%' .$search. '%');
        }
        $AircraftConfigurationDetails = $query->get();

        $response = [];
        foreach($AircraftConfigurationDetails as $AircraftConfigurationDetail){
            $response['results'][] = [
                "id" => $AircraftConfigurationDetail->coding,
                "text" => $AircraftConfigurationDetail->code . ' | ' . $AircraftConfigurationDetail->name . ' | ' . $AircraftConfigurationDetail->alias_name
            ];
        }

        return response()->json($response);
    }

}
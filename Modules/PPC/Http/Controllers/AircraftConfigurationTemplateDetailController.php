<?php

namespace Modules\PPC\Http\Controllers;

use Modules\PPC\Entities\AircraftConfigurationTemplateDetail;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AircraftConfigurationTemplateDetailController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(AircraftConfigurationTemplateDetail::class, 'configuration_template_detail');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $aircraft_configuration_template_id = $request->id;
        
        $data = AircraftConfigurationTemplateDetail::where('aircraft_configuration_template_id', $aircraft_configuration_template_id)
                                                ->with(['item:id,code,name',
                                                        'item_group:id,item_id,alias_name,coding,parent_coding'])
                                                ->orderBy('created_at','asc')
                                                ->get();
        return Datatables::of($data)
            ->addColumn('status', function($row){
                if ($row->status == 1){
                    return '<label class="label label-success">Active</label>';
                } else{
                    return '<label class="label label-danger">Inactive</label>';
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
            ->addColumn('action', function($row){
                $noAuthorize = true;
                if(Auth::user()->can('update', AircraftConfigurationTemplateDetail::class)) {
                    $updateable = 'button';
                    $updateValue = $row->id;
                    $noAuthorize = false;
                }
                if(Auth::user()->can('delete', AircraftConfigurationTemplateDetail::class)) {
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

    public function tree(Request $request)
    {
        $aircraft_configuration_template_id = $request->id;
        
        $datas = AircraftConfigurationTemplateDetail::where('aircraft_configuration_template_id', $aircraft_configuration_template_id)
                                                ->with(['item:id,code,name',
                                                        'item_group:id,item_id,alias_name'])
                                                ->where('aircraft_configuration_template_details.status','1')
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
        $request->validate([
            'item_id' => ['required'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        DB::beginTransaction();
        $AircraftConfigurationTemplateDetail = AircraftConfigurationTemplateDetail::create([
            'uuid' =>  Str::uuid(),

            'aircraft_configuration_template_id' => $request->aircraft_configuration_template_id,
            'item_id' => $request->item_id,
            'alias_name' => $request->alias_name,
            'description' => $request->description,
            'parent_coding' => $request->parent_coding,

            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        $AircraftConfigurationTemplateDetail->update([
            'coding' => $AircraftConfigurationTemplateDetail->aircraft_configuration_template_id . '-' . $AircraftConfigurationTemplateDetail->id,
        ]);
        DB::commit();

        return response()->json(['success' => 'Item/Component Data has been Added']);
    }

    public function show(AircraftConfigurationTemplateDetail $AircraftConfigurationTemplateDetail)
    {
        return view('ppc::pages.aircraft-configuration-template-detail.show', compact('AircraftConfigurationTemplateDetail'));
    }

    public function update(Request $request, AircraftConfigurationTemplateDetail $ConfigurationTemplateDetail)
    {
        $request->validate([
            'item_id' => ['required'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        $currentRow = AircraftConfigurationTemplateDetail::where('id', $ConfigurationTemplateDetail->id)->first();

        if ($request->parent_coding == $currentRow->coding) {
            $parent_coding = null;
        }
        else {
            $parent_coding = $request->parent_coding;
        }

        $currentRow
            ->update([
                'item_id' => $request->item_id,
                'alias_name' => $request->alias_name,
                'description' => $request->description,
                'parent_coding' => $parent_coding,

                'status' => $status,
                'updated_by' => Auth::user()->id,
        ]);
        
        return response()->json(['success' => 'Item/Component Data has been Updated']);
    }

    public function destroy(AircraftConfigurationTemplateDetail $ConfigurationTemplateDetail)
    {
        $currentRow = AircraftConfigurationTemplateDetail::where('id', $ConfigurationTemplateDetail->id)->first();
        $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        AircraftConfigurationTemplateDetail::destroy($ConfigurationTemplateDetail->id);
        return response()->json(['success' => 'Item/Component Data has been Deleted']);
    }

    public function select2Parent(Request $request)
    {
        $search = $request->term;
        $aircraft_configuration_template_id = $request->aircraft_configuration_template_id;

        $query = DB::table('aircraft_configuration_template_details')
                    ->leftJoin('items', 'aircraft_configuration_template_details.item_id', '=', 'items.id')
                    ->where('aircraft_configuration_template_details.aircraft_configuration_template_id', $aircraft_configuration_template_id)
                    ->where('aircraft_configuration_template_details.status', '1')
                    ->select('aircraft_configuration_template_details.id', 'aircraft_configuration_template_details.coding', 'aircraft_configuration_template_details.alias_name', 'items.code', 'items.name');

        if($search != ''){
            $query = $query->where('items.name', 'like', '%' .$search. '%')
                            ->orWhere('items.code', 'like', '%' .$search. '%');
        }
        $AircraftConfigurationTemplateDetails = $query->get();

        $response = [];
        foreach($AircraftConfigurationTemplateDetails as $AircraftConfigurationTemplateDetail){
            $response['results'][] = [
                "id" => $AircraftConfigurationTemplateDetail->coding,
                "text" => $AircraftConfigurationTemplateDetail->code . ' | ' . $AircraftConfigurationTemplateDetail->name . ' | ' . $AircraftConfigurationTemplateDetail->alias_name
            ];
        }

        return response()->json($response);
    }

}
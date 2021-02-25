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
                    return '<p class="text-muted font-italic">Not Authorized</p>';
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

        $currentRow = AircraftConfigurationTemplateDetail::where('id', $ConfigurationTemplateDetail->id)
                                                    ->with('all_childs')
                                                    ->first();

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

        if (Self::isValidParent($currentRow, $request->parent_coding)) {
            if ($request->parent_coding == $currentRow->coding) {
                $parent_coding = null;
            }
            else {
                $parent_coding = null;
            }
        }
        else {
            return response()->json(['error' => "The Choosen Parent is Already in Child of this Item"]);
        }

        DB::beginTransaction();
        $currentRow
            ->update([
                'item_id' => $request->item_id,
                'alias_name' => $request->alias_name,
                'description' => $request->description,
                'parent_coding' => $parent_coding,

                'status' => $status,
                'updated_by' => Auth::user()->id,
        ]);
        if (sizeof($currentRow->all_childs) > 0) {
            Self::updateChilds($currentRow, $status);
        }
        DB::commit();

        return response()->json(['success' => 'Item/Component Data has been Updated']);
    }

    public static function updateChilds($currentRow, $status)
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

    public static function isValidParent($currentRow, $parent_coding)
    {
        $isValid = true;
        foreach($currentRow->all_childs as $childRow) {
            if ($parent_coding == $childRow->coding) {
                $isValid = false;
                return $isValid;
                break;
            }
            else if (sizeof($childRow->all_childs) > 0) {
                Self::isValidParent($childRow, $parent_coding);
            }
        }
        return $isValid;
    }

    public function destroy(AircraftConfigurationTemplateDetail $ConfigurationTemplateDetail)
    {
        $currentRow = AircraftConfigurationTemplateDetail::where('id', $ConfigurationTemplateDetail->id)
                                                ->with('all_childs')
                                                ->first();

        if (sizeof($currentRow->all_childs) > 0) {
            return response()->json(['error' => "This Item/Component has Child(s) Item, You Can't Directly Delete this Item/Component"]);
        }
        else {
            $currentRow
            ->update([
                'deleted_by' => Auth::user()->id,
            ]);
            AircraftConfigurationTemplateDetail::destroy($ConfigurationTemplateDetail->id);
            return response()->json(['success' => 'Item/Component Data has been Deleted']);
        }
    }

    public function select2Parent(Request $request)
    {
        $search = $request->term;
        $aircraft_configuration_template_id = $request->aircraft_configuration_template_id;

        if($search != ''){
            $query = AircraftConfigurationTemplateDetail::with(['item' => function($q) use ($search) {
                        $q->where('items.code', 'like', '%' .$search. '%')
                        ->orWhere('items.name', 'like', '%' .$search. '%');
                    }])
            ->where('aircraft_configuration_template_id', $aircraft_configuration_template_id)
            ->where('status', 1);
        }
        $AircraftConfigurationTemplateDetails = $query->get();
        
        $response = [];
        foreach($AircraftConfigurationTemplateDetails as $AircraftConfigurationTemplateDetail){
            if($AircraftConfigurationTemplateDetail->item) {
                $item_code = $AircraftConfigurationTemplateDetail->item->code;
                $item_name = $AircraftConfigurationTemplateDetail->item->name;
            }
            else {
                $item_code = ' ';
                $item_name = ' ';
            }

            $response['results'][] = [
                "id" => $AircraftConfigurationTemplateDetail->coding,
                "text" => $item_code . ' | ' . $item_name . ' | ' . $AircraftConfigurationTemplateDetail->alias_name
            ];
        }
        return response()->json($response);
    }
}
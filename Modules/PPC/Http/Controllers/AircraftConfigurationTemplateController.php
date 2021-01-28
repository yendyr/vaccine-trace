<?php

namespace Modules\PPC\Http\Controllers;

use Modules\PPC\Entities\AircraftConfigurationTemplate;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AircraftConfigurationTemplateController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(AircraftConfigurationTemplate::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AircraftConfigurationTemplate::all();
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
                    if(Auth::user()->can('update', AircraftConfigurationTemplate::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', AircraftConfigurationTemplate::class)) {
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

        return view('ppc::pages.aircraft-configuration-template.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'max:30', 'unique:aircraft_configuration_templates,code'],
            'name' => ['required', 'max:30'],
            'aircraft_type_id' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        $AircraftConfigurationTemplate = AircraftConfigurationTemplate::create([
            'uuid' =>  Str::uuid(),
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'aircraft_type_id' => $request->aircraft_type_id,

            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);

        return response()->json(['success' => 'Aircraft Configuration Template Data has been Saved',
                                'id' => $AircraftConfigurationTemplate->id]);
    }

    public function show(AircraftConfigurationTemplate $AircraftConfigurationTemplate)
    {
        return view('ppc::pages.aircraft-configuration-template.show', compact('AircraftConfigurationTemplate'));
    }

    public function edit(AircraftConfigurationTemplate $AircraftConfigurationTemplate)
    {
        return view('ppc::pages.aircraft-configuration-template.edit', compact('AircraftConfigurationTemplate'));
    }

    public function update(Request $request, AircraftConfigurationTemplate $AircraftConfigurationTemplate)
    {
        $request->validate([
            'name' => ['required', 'max:30'],
            'aircraft_type_id' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        $currentRow = AircraftConfigurationTemplate::where('id', $AircraftConfigurationTemplate->id)->first();
        if ( $currentRow->code == $request->code) {
            $currentRow
                ->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'aircraft_type_id' => $request->manufacturer_id,
                    'status' => $status,
                    'updated_by' => Auth::user()->id,
            ]);
        }
        else {
            $currentRow
                ->update([
                    'code' => $request->code,
                    'name' => $request->name,
                    'description' => $request->description,
                    'aircraft_type_id' => $request->manufacturer_id,
                    'status' => $status,
                    'updated_by' => Auth::user()->id,
            ]);
        }
        return response()->json(['success' => 'Aircraft Configuration Template Data has been Updated']);
    }

    public function destroy(AircraftConfigurationTemplate $AircraftConfigurationTemplate)
    {
        $currentRow = AircraftConfigurationTemplate::where('id', $AircraftConfigurationTemplate->id)->first();
        $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        AircraftConfigurationTemplate::destroy($AircraftConfigurationTemplate->id);
        return response()->json(['success' => 'Aircraft Configuration Template Data has been Deleted']);
    }

    public function select2(Request $request)
    {
        $search = $request->q;

        $query = AircraftConfigurationTemplate::orderby('name','asc')
                    ->select('id','name')
                    ->where('status', 1);

        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%');
        }
        $AircraftConfigurationTemplates = $query->get();

        $response = [];
        foreach($AircraftConfigurationTemplates as $AircraftConfigurationTemplate){
            $response['results'][] = [
                "id"=>$AircraftConfigurationTemplate->id,
                "text"=>$AircraftConfigurationTemplate->name
            ];
        }

        return response()->json($response);
    }

}
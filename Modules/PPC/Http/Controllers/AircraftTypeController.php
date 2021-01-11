<?php

namespace Modules\PPC\Http\Controllers;

use Modules\PPC\Entities\AircraftType;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AircraftTypeController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(AircraftType::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AircraftType::all();
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
                    if(Auth::user()->can('update', AircraftType::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', AircraftType::class)) {
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

        return view('ppc::pages.aircraft-type.index');
    }

    public function create()
    {
        return view('ppc::pages.aircraft-type.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'max:30', 'unique:taskcard_types,code'],
            'name' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        AircraftType::create([
            'uuid' =>  Str::uuid(),
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Aircraft Type Data has been Added']);
    
    }

    public function show(AircraftType $AircraftType)
    {
        return view('ppc::pages.aircraft-type.show');
    }

    public function edit(AircraftType $AircraftType)
    {
        return view('ppc::pages.aircraft-type.edit', compact('AircraftType'));
    }

    public function update(Request $request, AircraftType $AircraftType)
    {
        $request->validate([
            'code' => ['required', 'max:30'],
            'name' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        $currentRow = AircraftType::where('id', $AircraftType->id)->first();
        if ( $currentRow->code == $request->code) {
            $currentRow
                ->update([
                    'name' => $request->name,
                    'description' => $request->description,
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
                    'status' => $status,
                    'updated_by' => Auth::user()->id,
            ]);
        }
        return response()->json(['success' => 'Aircraft Type Data has been Updated']);
    
    }

    public function destroy(AircraftType $AircraftType)
    {
        AircraftType::destroy($AircraftType->id);
        return response()->json(['success' => 'Data Deleted Successfully']);
    }

}
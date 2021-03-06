<?php

namespace Modules\SupplyChain\Http\Controllers;

use Modules\SupplyChain\Entities\Warehouse;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class WarehouseController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Warehouse::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Warehouse::with(['mutation_origins', 'mutation_destinations']);

            return Datatables::of($data)
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<label class="label label-success">Active</label>';
                    } else{
                        return '<label class="label label-danger">Inactive</label>';
                    }
                })
                ->addColumn('is_aircraft', function($row){
                    if ($row->is_aircraft == 0){
                        return '<label class="label label-warning">No</label>';
                    } else{
                        return '<label class="label label-primary">Yes</label>';
                    }
                })
                ->addColumn('creator_name', function($row){
                    return $row->creator->name ?? '-';
                })
                ->addColumn('updater_name', function($row){
                    return $row->updater->name ?? '-';
                })
                ->addColumn('action', function($row){
                    if ($row->is_aircraft == 0) {
                        $noAuthorize = true;
                        $deleteable = null;
                        $deleteId = null;

                        if(Auth::user()->can('update', Warehouse::class)) {
                            $updateable = 'button';
                            $updateValue = $row->id;
                            $noAuthorize = false;
                        }
                        if(Auth::user()->can('delete', Warehouse::class) && ($row->mutation_origins->count() == 0 && $row->mutation_destinations->count() == 0)) {
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
                    }
                    else {
                        return "<p class='text-muted font-italic'>Can't Modify Aircraft Here</p>";
                    }
                    
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('supplychain::pages.warehouse.index');
    }

    public function create()
    {
        return view('supplychain::pages.warehouse.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'max:30', 'unique:warehouses,code'],
            'name' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        Warehouse::create([
            'uuid' =>  Str::uuid(),
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Warehouse Data has been Added']);
    
    }

    public function show(Warehouse $Warehouse)
    {
        return view('supplychain::pages.warehouse.show');
    }

    public function edit(Warehouse $Warehouse)
    {
        return view('supplychain::pages.warehouse.edit', compact('Warehouse'));
    }

    public function update(Request $request, Warehouse $Warehouse)
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

        $currentRow = Warehouse::where('id', $Warehouse->id)->first();
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
        return response()->json(['success' => 'Warehouse Data has been Updated']);
    
    }

    public function destroy(Warehouse $Warehouse)
    {
        $currentRow = Warehouse::where('id', $Warehouse->id)->first();
        $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        Warehouse::destroy($Warehouse->id);
        return response()->json(['success' => 'Warehouse Data has been Deleted']);
    }

    public function select2(Request $request)
    {
        $search = $request->q;

        $query = Warehouse::orderby('name','asc')
                    ->select('id','code','name')
                    ->where('status', 1)
                    ->where('is_aircraft', 0);

        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%');
        }
        $Warehouses = $query->get();

        $response = [];
        foreach($Warehouses as $Warehouse){
            $response['results'][] = [
                "id" => $Warehouse->id,
                "text" => $Warehouse->code . ' | ' . $Warehouse->name
            ];
        }
        return response()->json($response);
    }
}
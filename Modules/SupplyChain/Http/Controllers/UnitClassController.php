<?php

namespace Modules\SupplyChain\Http\Controllers;

use Modules\SupplyChain\Entities\UnitClass;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class UnitClassController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(UnitClass::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = UnitClass::all();
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
                    if(Auth::user()->can('update', UnitClass::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', UnitClass::class)) {
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

        return view('supplychain::pages.unit-class.index');
    }

    public function create()
    {
        return view('supplychain::pages.unit-class.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'max:30', 'unique:unit_classes,code'],
            'name' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        UnitClass::create([
            'uuid' =>  Str::uuid(),
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Unit Class has been Added']);
    
    }

    public function show(UnitClass $UnitClass)
    {
        return view('supplychain::pages.unit-class.show');
    }

    public function edit(UnitClass $UnitClass)
    {
        return view('supplychain::pages.unit-class.edit', compact('UnitClass'));
    }

    public function update(Request $request, UnitClass $UnitClass)
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

        $currentRow = UnitClass::where('id', $UnitClass->id)->first();
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
        return response()->json(['success' => 'Unit Class Data has been Updated']);
    
    }

    public function destroy(UnitClass $UnitClass)
    {
        $currentRow = UnitClass::where('id', $UnitClass->id)->first();
        $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        UnitClass::destroy($UnitClass->id);
        return response()->json(['success' => 'Unit Class Data has been Deleted']);
    }

    public function select2(Request $request)
    {
        $search = $request->q;

        $query = UnitClass::orderby('name','asc')
                    ->select('id','name')
                    ->where('status', 1);

        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%');
        }
        $UnitClasses = $query->get();

        $response = [];
        foreach($UnitClasses as $UnitClass){
            $response['results'][] = [
                "id"=>$UnitClass->id,
                "text"=>$UnitClass->name
            ];
        }

        return response()->json($response);
    }

}
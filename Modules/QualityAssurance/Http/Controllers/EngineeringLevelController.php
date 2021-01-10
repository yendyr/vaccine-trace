<?php

namespace Modules\QualityAssurance\Http\Controllers;

use Modules\QualityAssurance\Entities\EngineeringLevel;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class EngineeringLevelController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(EngineeringLevel::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = EngineeringLevel::all();
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
                    if(Auth::user()->can('update', EngineeringLevel::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', EngineeringLevel::class)) {
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

        return view('qualityassurance::pages.engineering-level.index');
    }

    public function create()
    {
        return view('qualityassurance::pages.engineering-level.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'max:30', 'unique:engineering_levels,code'],
            'name' => ['required', 'max:30'],
            'sequence_level' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        EngineeringLevel::create([
            'uuid' =>  Str::uuid(),
            'code' => $request->code,
            'name' => $request->name,
            'sequence_level' => $request->sequence_level,
            'description' => $request->description,
            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Engineering Level Data has been Added']);
    
    }

    public function show(EngineeringLevel $EngineeringLevel)
    {
        return view('qualityassurance::pages.engineering-level.show');
    }

    public function edit(EngineeringLevel $EngineeringLevel)
    {
        return view('qualityassurance::pages.engineering-level.edit', compact('EngineeringLevel'));
    }

    public function update(Request $request, EngineeringLevel $EngineeringLevel)
    {
        $request->validate([
            'code' => ['required', 'max:30'],
            'name' => ['required', 'max:30'],
            'sequence_level' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        $currentRow = EngineeringLevel::where('id', $EngineeringLevel->id)->first();
        if ( $currentRow->code == $request->code) {
            $currentRow
                ->update([
                    'name' => $request->name,
                    'sequence_level' => $request->sequence_level,
                    'description' => $request->description,
                    'status' => $status,
                    'updated_by' => $request->user()->id,
            ]);
        }
        else {
            $currentRow
                ->update([
                    'code' => $request->code,
                    'name' => $request->name,
                    'sequence_level' => $request->sequence_level,
                    'description' => $request->description,
                    'status' => $status,
                    'updated_by' => $request->user()->id,
            ]);
        }

        return response()->json(['success' => 'EngineeringLevel Data has been Updated']);
    
    }

    public function destroy(EngineeringLevel $EngineeringLevel)
    {
        EngineeringLevel::destroy($EngineeringLevel->id);
        return response()->json(['success' => 'Data Deleted Successfully']);
    }

}
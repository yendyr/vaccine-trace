<?php

namespace Modules\PPC\Http\Controllers;

use Modules\PPC\Entities\TaskcardGroup;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TaskcardGroupController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(TaskcardGroup::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TaskcardGroup::all();
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
                    if(Auth::user()->can('update', TaskcardGroup::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', TaskcardGroup::class)) {
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

        return view('ppc::pages.taskcard-group.index');
    }

    public function create()
    {
        return view('ppc::pages.taskcard-group.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'max:30', 'unique:taskcard_groups,code'],
            'name' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        TaskcardGroup::create([
            'uuid' =>  Str::uuid(),
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'parent_id' => $request->select2_parent_name,
            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Task Card Group Data has been Added']);
    
    }

    public function show(TaskcardGroup $TaskcardGroup)
    {
        return view('ppc::pages.taskcard-group.show');
    }

    public function edit(TaskcardGroup $TaskcardGroup)
    {
        return view('ppc::pages.taskcard-group.edit', compact('TaskcardGroup'));
    }

    public function update(Request $request, TaskcardGroup $TaskcardGroup)
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

        $currentRow = TaskcardGroup::where('id', $TaskcardGroup->id)->first();
        if ( $currentRow->code == $request->code) {
            $currentRow
                ->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'parent_id' => $request->select2_parent_name,
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
                    'parent_id' => $request->select2_parent_name,
                    'status' => $status,
                    'updated_by' => Auth::user()->id,
            ]);
        }
        return response()->json(['success' => 'Task Card Group Data has been Updated']);
    
    }

    public function destroy(TaskcardGroup $TaskcardGroup)
    {
        TaskcardGroup::destroy($TaskcardGroup->id);
        return response()->json(['success' => 'Data Deleted Successfully']);
    }

    public function select2Parent(Request $request)
    {
        $search = $request->q;
        $query = TaskcardGroup::orderby('name','asc')->select('id','name')->where('status', 1);
        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%');
        }
        $TaskcardGroups = $query->get();

        $response = [];
        foreach($TaskcardGroups as $TaskcardGroup){
            $response['results'][] = [
                "id"=>$TaskcardGroup->id,
                "text"=>$TaskcardGroup->name
            ];
        }
        $response['results'][] = [
            "id" => 0,
            "text" => 'none',
        ];

        return response()->json($response);
    }

}
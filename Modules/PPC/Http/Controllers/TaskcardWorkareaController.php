<?php

namespace Modules\PPC\Http\Controllers;

use Modules\PPC\Entities\TaskcardWorkarea;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TaskcardWorkareaController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(TaskcardWorkarea::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TaskcardWorkarea::all();
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
                    if(Auth::user()->can('update', TaskcardWorkarea::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', TaskcardWorkarea::class)) {
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

        return view('ppc::pages.taskcard-workarea.index');
    }

    public function create()
    {
        return view('ppc::pages.taskcard-workarea.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'max:30', 'unique:taskcard_workareas,code'],
            'name' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        TaskcardWorkarea::create([
            'uuid' =>  Str::uuid(),
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Task Card Work Area has been Added']);
    
    }

    public function show(TaskcardWorkarea $TaskcardWorkarea)
    {
        return view('ppc::pages.taskcard-workarea.show');
    }

    public function edit(TaskcardWorkarea $TaskcardWorkarea)
    {
        return view('ppc::pages.taskcard-workarea.edit', compact('TaskcardWorkarea'));
    }

    public function update(Request $request, TaskcardWorkarea $TaskcardWorkarea)
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

        $currentRow = TaskcardWorkarea::where('id', $TaskcardWorkarea->id)->first();
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
        return response()->json(['success' => 'Task Card Work Area has been Updated']);
    
    }

    public function destroy(TaskcardWorkarea $TaskcardWorkarea)
    {
        $currentRow = TaskcardWorkarea::where('id', $TaskcardWorkarea->id)->first();
        $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        TaskcardWorkarea::destroy($TaskcardWorkarea->id);
        return response()->json(['success' => 'Task Card Work Area Data has been Deleted']);
    }

    public function select2(Request $request)
    {
        $search = $request->q;

        $query = TaskcardWorkarea::orderby('name','asc')
                    ->select('id','name')
                    ->where('status', 1);

        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%');
        }
        $TaskcardWorkareas = $query->get();

        $response = [];
        foreach($TaskcardWorkareas as $TaskcardWorkarea){
            $response['results'][] = [
                "id"=>$TaskcardWorkarea->id,
                "text"=>$TaskcardWorkarea->name
            ];
        }

        return response()->json($response);
    }

}
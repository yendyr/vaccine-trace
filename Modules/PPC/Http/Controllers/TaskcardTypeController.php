<?php

namespace Modules\PPC\Http\Controllers;

use Modules\PPC\Entities\TaskcardType;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TaskcardTypeController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(TaskcardType::class, TaskcardType::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TaskcardType::all();
            return Datatables::of($data)
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<label class="label label-success">Active</label>';
                    } else{
                        return '<label class="label label-danger">Inactive</label>';
                    }
                })
                ->addColumn('action', function($row){
                    $noAuthorize = true;
                    if(Auth::user()->can('update', TaskcardType::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', TaskcardType::class)) {
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

        return view('ppc::pages.taskcard.type.index');
    }

    public function create()
    {
        return view('ppc::pages.taskcard.type.create');
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

        TaskcardType::create([
            'uuid' =>  Str::uuid(),
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Task Card Type Data has been Added']);
    
    }

    public function show(TaskcardType $TaskcardType)
    {
        return view('ppc::pages.taskcard.type.show');
    }

    public function edit(TaskcardType $TaskcardType)
    {
        return view('ppc::pages.taskcard.type.edit', compact('TaskcardType'));
    }

    public function update(Request $request, TaskcardType $TaskcardType)
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

        TaskcardType::where('id', $TaskcardType->id)
            ->update([
                'code' => $request->code,
                'name' => $request->name,
                'description' => $request->description,
                'status' => $status,
                'updated_by' => $request->user()->id,
        ]);

        // return redirect('/ppc/taskcard/type')->with('status', 'Task Card Type Data has been Updated!');
        return response()->json(['success' => 'Task Card Type Data has been Updated']);
    
    }

    public function delete(TaskcardType $TaskcardType)
    {
        TaskcardType::destroy($TaskcardType->id);
        return response()->json(['success' => 'Data Deleted Successfully']);
    }

}
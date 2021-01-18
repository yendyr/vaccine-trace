<?php

namespace Modules\PPC\Http\Controllers;

use Modules\PPC\Entities\TaskcardDocumentLibrary;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TaskcardDocumentLibraryController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(TaskcardDocumentLibrary::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TaskcardDocumentLibrary::all();
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
                    if(Auth::user()->can('update', TaskcardDocumentLibrary::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', TaskcardDocumentLibrary::class)) {
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

        return view('ppc::pages.taskcard-document-library.index');
    }

    public function create()
    {
        return view('ppc::pages.taskcard-document-library.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'max:30', 'unique:taskcard_document_libraries,code'],
            'name' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        TaskcardDocumentLibrary::create([
            'uuid' =>  Str::uuid(),
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Task Card Document Library Data has been Added']);
    
    }

    public function show(TaskcardDocumentLibrary $TaskcardDocumentLibrary)
    {
        return view('ppc::pages.taskcard-document-library.show');
    }

    public function edit(TaskcardDocumentLibrary $TaskcardDocumentLibrary)
    {
        return view('ppc::pages.taskcard-document-library.edit', compact('TaskcardDocumentLibrary'));
    }

    public function update(Request $request, TaskcardDocumentLibrary $TaskcardDocumentLibrary)
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

        $currentRow = TaskcardDocumentLibrary::where('id', $TaskcardDocumentLibrary->id)->first();
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
        return response()->json(['success' => 'Task Card Document Library Data has been Updated']);
    
    }

    public function destroy(TaskcardDocumentLibrary $TaskcardDocumentLibrary)
    {
        TaskcardDocumentLibrary::destroy($TaskcardDocumentLibrary->id);
        return response()->json(['success' => 'Data Deleted Successfully']);
    }

    public function select2(Request $request)
    {
        $search = $request->q;

        $query = TaskcardDocumentLibrary::orderby('name','asc')
                    ->select('id','name')
                    ->where('status', 1);

        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%');
        }
        $TaskcardDocumentLibraries = $query->get();

        $response = [];
        foreach($TaskcardDocumentLibraries as $TaskcardDocumentLibrary){
            $response['results'][] = [
                "id"=>$TaskcardDocumentLibrary->id,
                "text"=>$TaskcardDocumentLibrary->name
            ];
        }

        return response()->json($response);
    }

}
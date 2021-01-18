<?php

namespace Modules\QualityAssurance\Http\Controllers;

use Modules\QualityAssurance\Entities\TaskReleaseLevel;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TaskReleaseLevelController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(TaskReleaseLevel::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TaskReleaseLevel::with(['engineering_level:id,name']);
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
                    if(Auth::user()->can('update', TaskReleaseLevel::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', TaskReleaseLevel::class)) {
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

        return view('qualityassurance::pages.task-release-level.index');
    }

    public function create()
    {
        return view('qualityassurance::pages.task-release-level.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'max:30', 'unique:task_release_levels,code'],
            'name' => ['required', 'max:30'],
            'sequence_level' => ['required', 'max:30', 'unique:task_release_levels,sequence_level'],
            'authorized_engineering_level' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        TaskReleaseLevel::create([
            'uuid' =>  Str::uuid(),
            'code' => $request->code,
            'name' => $request->name,
            'sequence_level' => $request->sequence_level,
            'authorized_engineering_level' => $request->authorized_engineering_level,
            'description' => $request->description,
            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Task Release Level Data has been Added']);
    
    }

    public function show(TaskReleaseLevel $TaskReleaseLevel)
    {
        return view('qualityassurance::pages.task-release-level.show');
    }

    public function edit(TaskReleaseLevel $TaskReleaseLevel)
    {
        return view('qualityassurance::pages.task-release-level.edit', compact('TaskReleaseLevel'));
    }

    public function update(Request $request, TaskReleaseLevel $TaskReleaseLevel)
    {
        $request->validate([
            'code' => ['required', 'max:30'],
            'name' => ['required', 'max:30'],
            'sequence_level' => ['required', 'max:30', 'unique:task_release_levels,sequence_level'],
            'authorized_engineering_level' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        $currentRow = TaskReleaseLevel::where('id', $TaskReleaseLevel->id)->first();
        if ( $currentRow->code == $request->code || $currentRow->sequence_level == $request->sequence_level) {
            $currentRow
                ->update([
                    'name' => $request->name,
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

        return response()->json(['success' => 'Task Release Level Data has been Updated']);
    
    }

    public function destroy(TaskReleaseLevel $TaskReleaseLevel)
    {
        TaskReleaseLevel::destroy($TaskReleaseLevel->id);
        return response()->json(['success' => 'Data Deleted Successfully']);
    }

}
<?php

namespace Modules\HumanResources\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\HumanResources\Entities\WorkingGroup;
use Modules\HumanResources\Entities\WorkingGroupDetail;
use Yajra\DataTables\Facades\DataTables;

class WorkingGroupController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(WorkingGroup::class, 'workgroup');
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = WorkingGroup::latest()->get();
            return DataTables::of($data)
                ->addColumn('shiftstatus', function($row){
                    if ($row->shiftstatus == 'Y'){
                        $shiftstatus['content'] = 'Shift';
                    } elseif($row->shiftstatus == 'N') {
                        $shiftstatus['content'] = 'Non shift';
                    }
                    $shiftstatus['value'] = $row->shiftstatus;
                    return $shiftstatus;
                })
                ->addColumn('rangerolling', function($row){
                    if ($row->rangerolling != null){
                        $rangerolling['content'] = ($row->rangerolling . " hari");
                    }
                    $rangerolling['value'] = $row->rangerolling;
                    return $rangerolling;
                })
                ->addColumn('roundtime', function($row){
                    if ($row->roundtime != null){
                        $roundtime['content'] = ($row->roundtime . " menit");
                    }
                    $roundtime['value'] = $row->roundtime;
                    return $roundtime;
                })
                ->addColumn('workfinger', function($row){
                    $workfingers = ['Not required', 'Required'];
                    $workfinger['content'] = $workfingers[$row->workfinger];
                    $workfinger['value'] = $row->workfinger;
                    return $workfinger;
                })
                ->addColumn('restfinger', function($row){
                    $restfingers = ['Not required', 'Required'];
                    $restfinger['content'] = $restfingers[$row->restfinger];
                    $restfinger['value'] = $row->restfinger;
                    return $restfinger;
                })
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<p class="text-success">Active</p>';
                    } else{
                        return '<p class="text-danger">Inactive</p>';
                    }
                })
                ->addColumn('action', function($row){
                    if(Auth::user()->can('update', WorkingGroup::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        return view('components.action-button', compact(['updateable', 'updateValue']));
                    }else{
                        return '<p class="text-muted">no action authorized</p>';
                    }
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('humanresources::pages.workgroup.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('humanresources::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()){
            $validationArray = $this->getValidationArray();
            $validation = $request->validate($validationArray);

            $dml = WorkingGroup::create([
                'uuid' => Str::uuid(),
                'workgroup' => $request->workgroup,
                'workname' => $request->workname,
                'shiftstatus' => $request->shiftstatus,
                'shiftrolling' => $request->shiftrolling,
                'rangerolling' => $request->rangerolling,
                'roundtime' => $request->roundtime,
                'workfinger' => $request->workfinger,
                'restfinger' => $request->restfinger,
                'remark' => $request->remark,
                'status' => $request->status,
                'owned_by' => $request->user()->company_id,
                'created_by' => $request->user()->id,
            ]);
            if ($dml){
                return response()->json(['success' => 'a new Working Group added successfully.']);
            }
            return response()->json(['error' => 'Error when creating data!']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Show the specified resource.
     * @param int WorkingGroup $workgroup
     * @return Response
     */
    public function show(WorkingGroup $workgroup)
    {
        return view('humanresources::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int WorkingGroup $workgroup
     * @return Response
     */
    public function edit(WorkingGroup $workgroup)
    {
        return view('humanresources::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int WorkingGroup $workgroup
     * @return Response
     */
    public function update(Request $request, WorkingGroup $workgroup)
    {
        if ($request->ajax()){
            $validationArray = $this->getValidationArray($request);
            unset($validationArray['workgroup']);
            $validation = $request->validate($validationArray);

            $dml = WorkingGroup::where('id', $workgroup->id)
                ->update([
//                'workgroup' => $request->workgroup,
                'workname' => $request->workname,
                'shiftstatus' => $request->shiftstatus,
                'shiftrolling' => $request->shiftrolling,
                'rangerolling' => $request->rangerolling,
                'roundtime' => $request->roundtime,
                'workfinger' => $request->workfinger,
                'restfinger' => $request->restfinger,
                'remark' => $request->remark,
                'status' => $request->status,
                'owned_by' => $request->user()->company_id,
                'updated_by' => $request->user()->id,
            ]);
            if ($dml){
                return response()->json(['success' => 'a Working Group data updated successfully.']);
            }
            return response()->json(['error' => 'Error when updating data!']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int WorkingGroup $workgroup
     * @return Response
     */
    public function destroy(WorkingGroup $workgroup)
    {
        //
    }

    //Validation array default for this controller
    public function getValidationArray($request = null){
        $validationArray = [
            'workgroup' => ['required', 'string', 'max:4', 'alpha_num', 'unique:working_groups,workgroup'],
            'workname' => ['nullable', 'string', 'max:50'],
            'shiftstatus' => ['required', 'string', 'size:1'],
            'shiftrolling' => ['required', 'numeric', 'digits_between:1,10'],
            'rangerolling' => ['required', 'numeric'],
            'roundtime' => ['nullable', 'numeric'],
            'workfinger' => ['nullable', 'numeric'],
            'restfinger' => ['nullable', 'numeric'],
            'remark' => ['nullable', 'string'],
            'status' => ['required', 'min:0', 'max:1'],
        ];

        return $validationArray;
    }
}

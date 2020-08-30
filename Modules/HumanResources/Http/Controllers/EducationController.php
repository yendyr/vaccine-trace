<?php

namespace Modules\HumanResources\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Modules\HumanResources\Entities\Education;
use Modules\HumanResources\Entities\Employee;
use Modules\HumanResources\Entities\HrLookup;
use Yajra\DataTables\Facades\DataTables;

class EducationController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Education::class, 'employee');
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if (isset($request->empid)){
                $data = Education::latest()->where('empid', $request->empid)->get();
            } else {
                $data = Education::latest()->get();
            }
            return DataTables::of($data)
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<p class="text-success">Active</p>';
                    } else{
                        return '<p class="text-danger">Inactive</p>';
                    }
                })
                ->addColumn('action', function($row){
                    if(Auth::user()->can('update', Education::class)) {
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
        return view('humanresources::pages.employee.index');
    }

    public function select2Edulvl(Request $request)
    {
        $search = $request->q;
        $query = HrLookup::select('maingrp', 'remark')->where('subkey', 'education')->where('lkey', 'edulvl')
            ->where('status', 1);

        if($search != ''){
            $query = $query->where('remark', 'like', '%' .$search. '%');
        }
        $results = $query->get();

        $response = [];
        foreach($results as $result){
            $response['results'][] = [
                "id"=>$result->maingrp,
                "text"=>$result->remark
            ];
        };

        return response()->json($response);
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
            $validationArray = $this->getValidationArray($request);
            $validation = $request->validate($validationArray);

            $dml = Education::create([
                'uuid' => Str::uuid(),
                'empid' => $request->empid,
                'instname' => $request->instname,
                'startperiod' => $request->startperiod,
                'finishperiod' => $request->finishperiod,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'major01' => $request->major01,
                'major02' => $request->major02,
                'minor01' => $request->minor01,
                'minor02' => $request->minor02,
                'edulvl' => $request->edulvl,
                'remark' => $request->remark,
                'status' => $request->status,
                'owned_by' => $request->user()->company_id,
                'created_by' => $request->user()->id,
            ]);
            if ($dml){
                return response()->json(['success' => 'a new Education data added successfully.']);
            }
            return response()->json(['error' => 'Error when creating data!']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(Education $education)
    {
        return view('humanresources::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Education $education)
    {
        return view('humanresources::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Education $education)
    {
        if ($request->ajax()){
            $validationArray = $this->getValidationArray($request);
            $validation = $request->validate($validationArray);

            $dml = Education::where('id', $education->id)
                ->update([
//                'empid' => $request->empid,
                'instname' => $request->instname,
                'startperiod' => $request->startperiod,
                'finishperiod' => $request->finishperiod,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'major01' => $request->major01,
                'major02' => $request->major02,
                'minor01' => $request->minor01,
                'minor02' => $request->minor02,
                'edulvl' => $request->edulvl,
                'remark' => $request->remark,
                'status' => $request->status,
                'owned_by' => $request->user()->company_id,
                'updated_by' => $request->user()->id,
            ]);
            if ($dml){
                return response()->json(['success' => 'a new Education data updated successfully.']);
            }
            return response()->json(['error' => 'Error when updating data!']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Education $education)
    {
        //
    }

    //Validation array default for this controller
    public function getValidationArray($request){
        $validationArray = [
            'empid' => ['required', 'string', 'max:20'],
            'instname' => ['required', 'string', 'max:100'],
            'startperiod' => ['required', 'string', 'max:4'],
            'finishperiod' => ['required', 'string', 'max:4'],
            'city' => ['required', 'string', 'max:30'],
            'state' => ['required', 'string', 'max:30'],
            'country' => ['required', 'string', 'max:30'],
            'major01' => ['nullable', 'string', 'max:50'],
            'major02' => ['nullable', 'string', 'max:50'],
            'minor01' => ['nullable', 'string', 'max:50'],
            'minor02' => ['nullable', 'string', 'max:50'],
            'edulvl' => ['required', 'string', 'max:50'],
            'remark' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'min:0', 'max:1'],
        ];

        return $validationArray;
    }
}

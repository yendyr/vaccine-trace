<?php

namespace Modules\HumanResources\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\HumanResources\Entities\Family;
use Modules\HumanResources\Entities\HrLookup;
use Yajra\DataTables\Facades\DataTables;

class FamilyController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Family::class, 'family');
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
                $data = Family::latest()->where('empid', $request->empid)->get();
            } else {
                $data = Family::latest()->get();
            }
            return DataTables::of($data)
                ->addColumn('gender', function($row){
                    if ($row->gender == 'L'){
                        $gender['content'] = 'Laki - laki';
                    } elseif ($row->gender == 'P'){
                        $gender['content'] = 'Perempuan';
                    }
                    $gender['value'] = $row->gender;
                    return $gender;
                })
                ->addColumn('maritalstatus', function($row){
                    $content = HrLookup::where('lkey', 'maritalstatus')->where('maingrp', $row->maritalstatus)
                        ->where('status', 1)->first();
                    $maritalstatus['content'] = $content->remark;
                    $maritalstatus['value'] = $row->maritalstatus;
                    return $maritalstatus;
                })
                ->addColumn('relationship', function($row){
                    $content = HrLookup::where('lkey', 'relationship')->where('maingrp', $row->relationship)
                        ->where('status', 1)->first();
                    $relationship['content'] = $content->remark;
                    $relationship['value'] = $row->relationship;
                    return $relationship;
                })
                ->addColumn('edulvl', function($row){
                    $content = HrLookup::where('lkey', 'edulvl')->where('maingrp', $row->edulvl)
                        ->where('status', 1)->first();
                    $edulvl['content'] = $content->remark;
                    $edulvl['value'] = $row->edulvl;
                    return $edulvl;
                })
                ->addColumn('job', function($row){
                    $content = HrLookup::where('lkey', 'job')->where('maingrp', $row->job)
                        ->where('status', 1)->first();
                    $job['content'] = $content->remark;
                    $job['value'] = $row->job;
                    return $job;
                })
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<p class="text-success">Active</p>';
                    } else{
                        return '<p class="text-danger">Inactive</p>';
                    }
                })
                ->addColumn('action', function($row){
                    if(Auth::user()->can('update', Family::class)) {
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

    public function select2Relationship(Request $request)
    {
        $search = $request->q;
        $query = HrLookup::select('maingrp', 'remark')->where('subkey', 'family')->where('lkey', 'relationship')
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
    public function select2Job(Request $request)
    {
        $search = $request->q;
        $query = HrLookup::select('maingrp', 'remark')->where('subkey', 'family')->where('lkey', 'job')
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

            $dml = Family::create([
                'uuid' => Str::uuid(),
                'empid' => $request->empidFamily,
                'famid' => $request->famid,
                'relationship' => $request->relationship,
                'fullname' => $request->fullname,
                'pob' => $request->pobFamily,
                'dob' => $request->dobFamily,
                'gender' => $request->genderFamily,
                'maritalstatus' => $request->maritalstatusFamily,
                'edulvl' => $request->edulvlFamily,
                'edumajor' => $request->edumajor,
                'job' => $request->jobFamily,
                'remark' => $request->remark,
                'status' => $request->status,
                'owned_by' => $request->user()->company_id,
                'created_by' => $request->user()->id,
            ]);
            if ($dml){
                return response()->json(['success' => 'a new Family data added successfully.']);
            }
            return response()->json(['error' => 'Error when creating data!']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Show the specified resource.
     * @param int Family $family
     * @return Response
     */
    public function show(Family $family)
    {
        return view('humanresources::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int Family $family
     * @return Response
     */
    public function edit(Family $family)
    {
        return view('humanresources::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int Family $family
     * @return Response
     */
    public function update(Request $request, Family $family)
    {
        if ($request->ajax()){
            $validationArray = $this->getValidationArray($request);
            unset($validationArray['empidFamily']);
            unset($validationArray['famid']);
            $validation = $request->validate($validationArray);

            $dml = Family::where('id', $family->id)
                ->update([
//                'empid' => $request->empidFamily,
//                'famid' => $request->famid,
                'relationship' => $request->relationship,
                'fullname' => $request->fullname,
                'pob' => $request->pobFamily,
                'dob' => $request->dobFamily,
                'gender' => $request->genderFamily,
                'maritalstatus' => $request->maritalstatusFamily,
                'edulvl' => $request->edulvlFamily,
                'edumajor' => $request->edumajor,
                'job' => $request->jobFamily,
                'remark' => $request->remark,
                'status' => $request->status,
                'owned_by' => $request->user()->company_id,
                'updated_by' => $request->user()->id,
            ]);
            if ($dml){
                return response()->json(['success' => 'a Family data updated successfully.']);
            }
            return response()->json(['error' => 'Error when creating data!']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int Family $family
     * @return Response
     */
    public function destroy(Family $family)
    {
        //
    }

    //Validation array default for this controller
    public function getValidationArray($request){
        $validationArray = [
            'empidFamily' => ['required', 'string', 'max:20'],
            'famid' => ['required', 'string', 'max:20'],
            'relationship' => ['required', 'string', 'max:2'],
            'fullname' => ['required', 'string', 'max:100'],
            'pobFamily' => ['required', 'string', 'max:30'],
            'dobFamily' => ['required', 'date'],
            'genderFamily' => ['required', 'string', 'size:1'],
            'maritalstatusFamily' => ['required', 'string', 'size:1'],
            'edulvlFamily' => ['required', 'string', 'max:50'],
            'edumajor' => ['nullable', 'string', 'max:50'],
            'jobFamily' => ['required', 'string', 'size:2'],
            'remark' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'min:0', 'max:1'],
        ];

        return $validationArray;
    }
}

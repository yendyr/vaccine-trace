<?php

namespace Modules\HumanResources\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\HumanResources\Entities\Attendance;
use Modules\HumanResources\Entities\HrLookup;
use Yajra\DataTables\DataTables;

class AttendanceController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Attendance::class, 'attendance');
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Attendance::latest()->get();
            return DataTables::of($data)
                ->addColumn('attdtype', function($row){
                    $query = HrLookup::select('maingrp', 'remark')->where('subkey', 'attendance')->where('lkey', 'attdtype')
                        ->where('maingrp', $row->attdtype)->first();
                    $attdtype['content'] = $query->remark;
                    $attdtype['value'] = $query->maingrp;
                    return $attdtype;
                })
                ->addColumn('attdtime', function($row){
                    if (isset($row->attdtime)){
                        $row->attdtime = date_format(date_create($row->attdtime),"H:i");
                    }
                    return $row->attdtime;
                })
                ->addColumn('deviceid', function($row){
                    if ($row->deviceid == 'XX'){
                        return 'Manual';
                    }
                    return $row->deviceid;
                })
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<p class="text-success">Active</p>';
                    } else{
                        return '<p class="text-danger">Inactive</p>';
                    }
                })
                ->addColumn('action', function($row){
                    if( Auth::user()->can('update', Attendance::class) ) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        if (Auth::user()->can('delete', Attendance::class)){
                            $deleteId = $row->id;
                            $deleteable = true;
                            return view('components.action-button', compact(['updateable', 'updateValue', 'deleteable', 'deleteId']));
                        }
                        return view('components.action-button', compact(['updateable', 'updateValue']));
                    }else{
                        return '<p class="text-muted">no action authorized</p>';
                    }
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('humanresources::pages.attendance.index');
    }

    public function select2Type(Request $request)
    {
        $search = $request->q;
        $query = HrLookup::select('maingrp', 'remark')->where('subkey', 'attendance')->where('lkey', 'attdtype')
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

    public function validateData(){
        return view('humanresources::pages.attendance.validation');
    }
    public function datatableIn(Request $request) {
        if ($request->ajax()) {
            $data = Attendance::latest()->whereIn('attdtype', ['01', '03', '05'])->get();
            return DataTables::of($data)
                ->addColumn('attdtype', function($row){
                    $query = HrLookup::select('maingrp', 'remark')->where('subkey', 'attendance')->where('lkey', 'attdtype')
                        ->where('maingrp', $row->attdtype)->first();
                    $attdtype['content'] = $query->remark;
                    $attdtype['value'] = $query->maingrp;
                    return $attdtype;
                })
                ->addColumn('attdtime', function($row){
                    if (isset($row->attdtime)){
                        $row->attdtime = date_format(date_create($row->attdtime),"H:i");
                    }
                    return $row->attdtime;
                })
                ->addColumn('deviceid', function($row){
                    if ($row->deviceid == 'XX'){
                        return 'Manual';
                    }
                    return $row->deviceid;
                })
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<p class="text-success">Active</p>';
                    } else{
                        return '<p class="text-danger">Inactive</p>';
                    }
                })
                ->escapeColumns([])
                ->make(true);
        }
    }
    public function datatableOut(Request $request) {
        if ($request->ajax()) {
            $data = Attendance::latest()->whereIn('attdtype', ['02', '04', '06'])->get();
            return DataTables::of($data)
                ->addColumn('attdtype', function($row){
                    $query = HrLookup::select('maingrp', 'remark')->where('subkey', 'attendance')->where('lkey', 'attdtype')
                        ->where('maingrp', $row->attdtype)->first();
                    $attdtype['content'] = $query->remark;
                    $attdtype['value'] = $query->maingrp;
                    return $attdtype;
                })
                ->addColumn('attdtime', function($row){
                    if (isset($row->attdtime)){
                        $row->attdtime = date_format(date_create($row->attdtime),"H:i");
                    }
                    return $row->attdtime;
                })
                ->addColumn('deviceid', function($row){
                    if ($row->deviceid == 'XX'){
                        return 'Manual';
                    }
                    return $row->deviceid;
                })
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<p class="text-success">Active</p>';
                    } else{
                        return '<p class="text-danger">Inactive</p>';
                    }
                })
                ->escapeColumns([])
                ->make(true);
        }
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

            date_default_timezone_set('Asia/Jakarta');
            $dml = Attendance::create([
                'uuid' => Str::uuid(),
                'empid' => $request->empidAttendance,
                'attdtype' => $request->attdtype,
                'attddate' => $request->attddate,
                'attdtime' => date_format(date_create($request->attdtime), 'H:i:s'),
                'deviceid' => "XX",
                'inputon' => date("Y-m-d H:i:s"),
                'status' => $request->status,
                'owned_by' => $request->user()->company_id,
                'created_by' => $request->user()->id,
            ]);
            if ($dml){
                return response()->json(['success' => 'a new Attendance data added successfully.']);
            }
            return response()->json(['error' => 'Error when creating data!']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Show the specified resource.
     * @param int Attendance $attendance
     * @return Response
     */
    public function show(Attendance $attendance)
    {
        return view('humanresources::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int Attendance $attendance
     * @return Response
     */
    public function edit(Attendance $attendance)
    {
        return view('humanresources::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int Attendance $attendance
     * @return Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        if ($request->ajax()){
            $validationArray = $this->getValidationArray($request);
            unset($validationArray['empidAttendance']);
            $validation = $request->validate($validationArray);

            date_default_timezone_set('Asia/Jakarta');
            $dml = Attendance::where('id', $attendance->id)
                ->update([
//                'empid' => $request->empid,
                    'attdtype' => $request->attdtype,
                    'attddate' => $request->attddate,
                    'attdtime' => date_format(date_create($request->attdtime), 'H:i:s'),
                    'deviceid' => "XX",
                    'inputon' => date("Y-m-d H:i:s"),
                    'status' => $request->status,
                    'owned_by' => $request->user()->company_id,
                    'updated_by' => $request->user()->id,
                ]);
            if ($dml){
                return response()->json(['success' => 'an Attendance data updated successfully.']);
            }
            return response()->json(['error' => 'Error when updating data!']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int Attendance $attendance
     * @return Response
     */
    public function destroy(Attendance $attendance)
    {
        Attendance::destroy($attendance->id);
        return response()->json(['success' => 'Attendance data deleted successfully.']);
    }

    //Validation array default for this controller
    public function getValidationArray($request){
        $validationArray = [
            'empidAttendance' => ['required', 'string', 'max:20'],
            'attdtype' => ['required', 'string', 'max:4'],
            'attddate' => ['required', 'date'],
            'attdtime' => ['required', 'date_format:H:i'],
            'status' => ['required', 'min:0', 'max:1'],
        ];

        return $validationArray;
    }
}

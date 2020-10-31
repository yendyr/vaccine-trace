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
use Modules\HumanResources\Entities\WorkingHourAttendance;
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

    public function validateAll(Request $request){
        if ($request->ajax()){
            $attendances = Attendance::all()->groupBy('attddate');
            $dmlCount = 0;
            foreach ($attendances as $attendance){ //ambil tiap satu grouping (tiap attddate)
                $workTypes = [];
                foreach ($attendance as $row) { //ambil tiap data lalu dikelompokkan tiap tipe
                    if ($row->attdtype == "01" || $row->attdtype == "02"){
                        $workTypes["normalWork"][] = $row;
                    }elseif ($row->attdtype == "03" || $row->attdtype == "04"){
                        $workTypes["tempPermit"][] = $row;
                    }elseif ($row->attdtype == "05" || $row->attdtype == "06"){
                        $workTypes["holidaywork"][] = $row;
                    }
                }
                $workTypeSign = 0;
                foreach ($workTypes as $workType) { //ambil tiap jenis workType
                    if (count($workType) == 2){
                        if ($workTypeSign == 0 || $workTypeSign == 2){ //type 0 = normalWork, 1 = tempPermit, 2 = holidayWork
                            $attdType = 01; // 01 = Kerja
                        }elseif ($workTypeSign == 1){
                            $attdType = 02; // 02 = ijin sementara
                        }

                        date_default_timezone_set('Asia/Jakarta'); //set timezone

                        $whourAttendance = WorkingHourAttendance::where('empid', $workType[0]->empid)
                            ->where('datestart', $workType[0]->attddate)->where('datefinish', $workType[1]->attddate)->get();
                        if (count($whourAttendance) == 0){
                            $rntimestart = $this->roundingtime($workType[0]->attdtype,$workType[0]->attdtime,30);
                            $rntimefinish = $this->roundingtime($workType[1]->attdtype,$workType[1]->attdtime,30);

                            $dml = WorkingHourAttendance::create([
                                'uuid' => Str::uuid(),
                                'empid' => $workType[0]->empid,
                                'workdate' => $workType[0]->attddate,
                                'attdtype' => $attdType,
                                'datestart' => $workType[0]->attddate,
                                'timestart' => $workType[0]->attdtime,
                                'datefinish' => $workType[1]->attddate,
                                'timefinish' => $workType[1]->attdtime,
                                'validateon' => date("Y-m-d H:i:s"),
                                'rndatestart' => $workType[0]->attddate,
                                'rntimestart' => $rntimestart,
                                'rndatefinish' => $workType[1]->attddate,
                                'rntimefinish' => $rntimefinish,
                                'status' => 1,
                                'owned_by' => $request->user()->company_id,
                                'created_by' => $request->user()->id,
                            ]);

                            //update status attendance
                            $this->updateStatus($workType[0], $workType[1],$request);
                            $dmlCount++;
                        }
                    }
                    $workTypeSign++;
                }
            }
            if ($dmlCount > 0){
                return response()->json(['success' => 'The new validated attendances data are saved in Working Hour Attendances datalist!']);
            }
            return response()->json(['error' => 'No attendance data can be validated!']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    private function roundingtime($attdtype, $time, $rndtime){
        if($attdtype == 01 || $attdtype == 03 || $attdtype == 05){
            $rounded_seconds = ceil(strtotime($time) / ($rndtime * 60)) * ($rndtime * 60);
        }elseif($attdtype == 02 || $attdtype == 04 || $attdtype == 06){
            $rounded_seconds = floor(strtotime($time) / ($rndtime * 60)) * ($rndtime * 60);
        }
        return date('H:i:s', $rounded_seconds);
    }

    private function updateStatus($data1, $data2, $request){
        Attendance::where('id', $data1->id)->orWhere('id', $data2->id)
            ->update([
                'status' => 2,
                'owned_by' => $request->user()->company_id,
                'updated_by' => $request->user()->id,
            ]);
    }

    public function validationView(){
        return view('humanresources::pages.attendance.validation');
    }
    public function datatableInOut(Request $request) {
        if ($request->ajax()) {
            if ($request->param == "in"){
                $data = Attendance::latest()->whereIn('attdtype', ['01', '03', '05'])->where('status', '!=', 2)->get();
            }elseif ($request->param == "out"){
                $data = Attendance::latest()->whereIn('attdtype', ['02', '04', '06'])->where('status', '!=', 2)->get();
            }
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
            $attdData = Attendance::where('attddate', $request->attddate)->where('attdtype', $request->attdtype)->get();

            if (count($attdData) == 0){
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
            }else{  //if existed
                return response()->json(['warning' => 'the attendance data type in that day has existed before!']);
            }

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

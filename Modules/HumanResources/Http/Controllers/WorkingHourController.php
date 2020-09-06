<?php

namespace Modules\HumanResources\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\HumanResources\Entities\Employee;
use Modules\HumanResources\Entities\Holiday;
use Modules\HumanResources\Entities\WorkingGroup;
use Modules\HumanResources\Entities\WorkingGroupDetail;
use Modules\HumanResources\Entities\WorkingHour;
use Yajra\DataTables\DataTables;

class WorkingHourController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(WorkingHour::class, 'working_hour');
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = WorkingHour::latest()->get();
            return DataTables::of($data)
                ->addColumn('whtimestart', function($row){
                    if (isset($row->whtimestart)){
                        $row->whtimestart = date_format(date_create($row->whtimestart),"H:i");
                    }
                    return $row->whtimestart;
                })
                ->addColumn('whtimefinish', function($row){
                    if (isset($row->whtimefinish)){
                        $row->whtimefinish = date_format(date_create($row->whtimefinish),"H:i");
                    }
                    return $row->whtimefinish;
                })
                ->addColumn('rstimestart', function($row){
                    if (isset($row->rstimestart)){
                        $row->rstimestart = date_format(date_create($row->rstimestart),"H:i");
                    }
                    return $row->rstimestart;
                })
                ->addColumn('rstimefinish', function($row){
                    if (isset($row->rstimefinish)){
                        $row->rstimefinish = date_format(date_create($row->rstimefinish),"H:i");
                    }
                    return $row->rstimefinish;
                })
                ->addColumn('stdhours', function($row){
                    if ($row->stdhours != null){
                        $stdhours['content'] = ($row->stdhours . " jam");
                    }
                    $stdhours['value'] = $row->stdhours;
                    return $stdhours;
                })
                ->addColumn('minhours', function($row){
                    if ($row->minhours != null){
                        $minhours['content'] = ($row->minhours . " jam");
                    }
                    $minhours['value'] = $row->minhours;
                    return $minhours;
                })->addColumn('worktype', function($row){
                    $worktype['value'] = $row->worktype;
                    if ($row->worktype == 'KB'){
                        $worktype['content'] = 'Keja Biasa';
                    } elseif ($row->worktype == 'KL'){
                        $worktype['content'] = 'Keja Libur';
                    }
                    return $worktype;
                })
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<p class="text-success">Active</p>';
                    } else{
                        return '<p class="text-danger">Inactive</p>';
                    }
                })
//                ->addColumn('action', function($row){
//                    if(Auth::user()->can('update', WorkingHour::class)) {
//                        $updateable = 'button';
//                        $updateValue = $row->id;
//                        return view('components.action-button', compact(['updateable', 'updateValue']));
//                    }else{
//                        return '<p class="text-muted">no action authorized</p>';
//                    }
//                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('humanresources::pages.employee.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('humanresources::pages.employee.index');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()){
            $request->merge([   //memvalidkan format date
                'datestart' => date("Y/m/d", strtotime($request->datestart)),
                'datefinish' => date("Y/m/d", strtotime($request->datefinish))
            ]);

            $validationArray = $this->getValidationArray($request);
            $validation = $request->validate($validationArray);

            //get Workgroup code
            $wgcode = Employee::select('workgrp')->where('empid', $request->empidWhour)->first();

            //get workdate
            $workdate = $request->datestart;
            while (strtotime($workdate) <= strtotime($request->datefinish) ){
                $daycode = date_format(date_create($workdate),"N");
                if($daycode == 7){
                    $daycode = 1;
                } else{
                    $daycode += 1;
                }
                $daycode = ('0'.$daycode);
                $wgdetails = WorkingGroupDetail::where('workgroup', $wgcode->workgrp)->where('daycode', $daycode)->get();

                $queries = Holiday::select('holidaydate')->where('status', 1)->get();
                foreach ($queries as $query) {  //get holidays date
                    $holidaydates[] = $query->holidaydate;
                }

                foreach ($wgdetails as $wgdetail){
                    if (in_array(date_format(date_create($workdate),"Y-m-d"), $holidaydates)){
                        $workstatus = 'L';
                    } else{
                        if ($wgdetail->worktype == 'KL'){
                            $workstatus = 'L';
                        } elseif ($wgdetail->worktype == 'KB'){
                            $workstatus = 'M';
                        }
                    }
                    $whourData = WorkingHour::where('empid', $request->empidWhour)
                        ->where('workdate',$workdate)->where('shiftno', $wgdetail->shiftno)->first();
                    if (!isset($whourData)){    //untuk
                        $whour = WorkingHour::create([
                            'uuid' => Str::uuid(),
                            'empid' => $request->empidWhour,
                            'workdate' => $workdate,
                            'shiftno' => $wgdetail->shiftno,
                            'whtimestart' => $wgdetail->whtimestart,
                            'whdatestart' => $workdate,
                            'whtimefinish' => $wgdetail->whtimefinish,
                            'whdatefinish' => (strtotime($wgdetail->whtimestart) <= strtotime($wgdetail->whtimefinish))
                                ? $workdate
                                : date('Y/m/d', strtotime($workdate .'+1 day')),
                            'rstimestart' => $wgdetail->rstimestart,
                            'rsdatestart' => $workdate,
                            'rstimefinish' => $wgdetail->rstimefinish,
                            'rsdatefinish' => (strtotime($wgdetail->rstimestart) <= strtotime($wgdetail->rstimefinish))
                                ? $workdate
                                : date('Y/m/d', strtotime($workdate .'+1 day')),
                            'stdhours' => $wgdetail->stdhours,
                            'minhours' => $wgdetail->minhours,
                            'worktype' => $wgdetail->worktype,
                            'workstatus' => $workstatus,
                            'status' => $request->status,
                            'owned_by' => $request->user()->company_id,
                            'created_by' => $request->user()->id,
                        ]);
                    }
                }
                $workdate = date('Y-m-d', strtotime($workdate .'+1 day'));  //get tomorrow
            }
            if (isset($whour)){
                return response()->json(['success' => 'a new Working hour added successfully.']);
            }
            return response()->json(['success' => 'no Working hour data added.']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Show the specified resource.
     * @param int WorkingHour $working_hour
     * @return Response
     */
    public function show(WorkingHour $working_hour)
    {
        return view('humanresources::pages.employee.index');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int WorkingHour $working_hour
     * @return Response
     */
    public function edit(WorkingHour $working_hour)
    {
        return view('humanresources::pages.employee.index');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int WorkingHour $working_hour
     * @return Response
     */
    public function update(Request $request, WorkingHour $working_hour)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int WorkingHour $working_hour
     * @return Response
     */
    public function destroy(WorkingHour $working_hour)
    {
        //
    }

    //Validation array default for this controller
    public function getValidationArray($request = null, $shiftno = null){
        $validationArray = [
            'empidWhour' => ['required', 'string', 'max:20'],
            'datestart' => ['required', 'date'],
            'datefinish' => ['required', 'date', 'gte:datestart'],
            'status' => ['required', 'min:0', 'max:1'],
        ];

        return $validationArray;
    }
}

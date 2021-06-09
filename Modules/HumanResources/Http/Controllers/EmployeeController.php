<?php

namespace Modules\HumanResources\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Modules\Gate\Entities\Company;
use Modules\HumanResources\Entities\Employee;
use Modules\HumanResources\Entities\HrLookup;
use Modules\HumanResources\Entities\OrganizationStructure;
use Modules\HumanResources\Entities\OrganizationStructureTitle;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Employee::class, 'employee');
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Employee::query();
            return DataTables::of($data)
                ->addColumn('gender', function($row){
                    if (isset($row->gender)){
                        if ($row->gender == 'L'){
                            $gender['content'] = 'Laki - laki';
                        } elseif ($row->gender == 'P'){
                            $gender['content'] = 'Perempuan';
                        }
                        $gender['value'] = $row->gender;
                        return $gender;
                    }else
                        return null;
                })
                ->addColumn('phone', function($row){
                    if (isset($row->mobile01)){
                        $phones['content'] = $row->mobile01;
                    } else if (isset($row->mobile02)){
                        $phones['content'] = $row->mobile02;
                    } else if(isset($row->mobile01) && isset($row->mobile02)){
                        $phones['content'] = $row->mobile01 . ', ' . $row->mobile02;
                    }
                    $phones['mobile01'] = $row->mobile01;
                    $phones['mobile02'] = $row->mobile02;
                    return $phones;
                })
                ->addColumn('maritalstatus', function($row){
                    $content = HrLookup::where('lkey', 'maritalstatus')->where('status', 1)->first();
                    $maritalstatus['content'] = $content->remark;
                    $maritalstatus['value'] = $row->maritalstatus;
                    return $maritalstatus;
                })
                ->addColumn('probation', function($row){
                    if ($row->probation == 'Y'){
                        $probation['content'] = 'Probation';
                    } elseif ($row->probation == 'N'){
                        $probation['content'] = 'Non probation';
                    }
                    $probation['value'] = $row->probation;
                    return $probation;
                })
                ->addColumn('cesscode', function($row){
                    $cesscodes = ['Resign', 'Retire'];
                    if (isset($row->cesscode)){
                        $indexCode = sprintf("%01d", $row->cesscode);
                        $cesscode['value'] = $row->cesscode;
                        $cesscode['content'] = ($row->cesscode . ' - ' . $cesscodes[($indexCode-1)]);
                        return $cesscode;
                    }else
                        return null;
                })
                ->addColumn('recruitby', function($row){
                    if (isset($row->recruitby)){
                        $recruitby['value'] = $row->recruitby;
                        $content = HrLookup::where('lkey', 'recruitby')->where('maingrp', $row->recruitby)
                            ->where('status', 1)->first();
                        $recruitby['content'] = $content->remark;
                        return $recruitby;
                    }else
                        return null;
                })
                ->addColumn('emptype', function($row){
                    $emptypes = ['Permanent', 'Temporary'];
                    if (isset($row->emptype)){
                        $indexType = sprintf("%01d", $row->emptype);
                        $emptype['value'] = $row->emptype;
                        $emptype['content'] = ($row->emptype . ' - ' . $emptypes[($indexType-1)]);
                        return $emptype;
                    }else
                        return null;
                })
                ->addColumn('orgcode', function($row){
                    if(isset($row->orgcode)){
                        $orgidentity['value'] = $row->orgcode;
                        $orgidentity['content'] = OrganizationStructure::select('orgname')->where('orgcode', $row->orgcode)->first()->orgname;
                        return $orgidentity;
                    }else
                        return null;
                })
                ->addColumn('orglvl', function($row){
                    $levels = ['Direksi', 'General', 'Divisi', 'Bagian', 'Seksi', 'Regu', 'Group'];
                    if (isset($row->orglvl)){
                        $level['value'] = $row->orglvl;
                        $level['content'] = $levels[($row->orglvl-1)];
                        return $level;
                    }else
                        return null;
                })
                ->addColumn('title', function($row){
                    $titles = ['Kepala', 'Wakil kepala', 'Anggota', 'Staff', 'Operator'];
                    if (isset($row->title)){
                        $title['value'] = $row->title;
                        $title['content'] = $titles[($row->title-1)];
                        return $title;
                    }else
                        return null;
                })
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<p class="text-success">Active</p>';
                    } else{
                        return '<p class="text-danger">Inactive</p>';
                    }
                })
                ->addColumn('action', function($row){
                    if(Auth::user()->can('update', Employee::class)) {
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

    public function select2Orgcode(Request $request)
    {
        $search = $request->q;
        $query = OrganizationStructure::select('orgcode', 'orgname')->where('status', 1);
        if($search != ''){
            $query = $query->where('orgcode', 'like', '%' .$search. '%')->orWhere('orgname', 'like', '%' .$search. '%');
        }
        $queryOs = $query->get();

        //get distinct orgcode in Organization Structure Title
        $queryOst = OrganizationStructureTitle::select('orgcode')->distinct()->where('status', 1)->get();
        foreach ($queryOst as $rowOst) {
            $orgcodeOst[] = $rowOst->orgcode;
        }
        //get if orgcode in Organization Structure Title contains orgcode in $query Organization Structure
        foreach ($queryOs as $i => $rowOs) {
            if (in_array($rowOs->orgcode, $orgcodeOst)){
                $orgcodes[$i] = $rowOs->orgcode;
                $orgnames[$i] = $rowOs->orgname;
            }
        }

        $response = [];
        foreach($orgcodes as $i => $rowCode){
            $response['results'][] = [
                "id"=>$rowCode,
                "text"=>($rowCode .' - '. $orgnames[$i])
            ];
        };

        return response()->json($response);
    }
    public function select2Title(Request $request)
    {
        $search = $request->q;
        if (isset($request->orgcode)){
            $query = OrganizationStructureTitle::select('titlecode')->where('orgcode', $request->orgcode);
            if($search != ''){
                $query = $query->where('titlecode', 'like', '%' .$search. '%');
            }
        }
        $results = $query->distinct()->get();

        $titles = [
            'Kepala', 'Wakil kepala', 'Anggota', 'Staff', 'Operator'
        ];
        $response = [];
        foreach($results as $result){
            $response['results'][] = [
                "id"=>$result->titlecode,
                "text"=>($titles[$result->titlecode-1])
            ];
        };

        return response()->json($response);
    }

    public function select2Jobtitle(Request $request)
    {
        $search = $request->q;
        if (isset($request->orgcode) && isset($request->titlecode)){
            $query = OrganizationStructureTitle::select('jobtitle')
                ->where('orgcode', $request->orgcode)
                ->where('titlecode', $request->titlecode)
                ->where('status', 1)->get();
        }

        $response = [];
        foreach($query as $result){
            $response['results'][] = [
                "id"=>$result->jobtitle,
                "text"=>$result->jobtitle
            ];
        };

        return response()->json($response);
    }
    public function select2Orglvl(Request $request)
    {
        if (isset($request->orgcode)){
            $query = OrganizationStructure::select('orglevel')->where('orgcode', $request->orgcode)
                ->where('status', 1)->first();
        }

        $orglevels = [
            'Direksi', 'General', 'Divisi', 'Bagian', 'Seksi', 'Regu', 'Grup'
        ];
        $response['results'][] = [
            "id"=>$query->orglevel,
            "text"=>$orglevels[$query->orglevel-1]
        ];

        return response()->json($response);
    }

    public function select2Recruitby(Request $request)
    {
        $search = $request->q;
        $query = HrLookup::select('maingrp', 'remark')->where('subkey', 'employee')->where('lkey', 'recruitby')
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
    public function select2Maritalstatus(Request $request)
    {
        $search = $request->q;
        $query = HrLookup::select('maingrp', 'remark')->where('subkey', 'employee')->where('lkey', 'maritalstatus')
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
    public function select2Bloodtype(Request $request)
    {
        $search = $request->q;
        $query = HrLookup::select('maingrp', 'remark')->where('subkey', 'employee')->where('lkey', 'bloodtype')
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
    public function select2Religion(Request $request)
    {
        $search = $request->q;
        $query = HrLookup::select('maingrp', 'remark')->where('subkey', 'employee')->where('lkey', 'religion')
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

    public function select2Empid(Request $request)
    {
        $search = $request->q;
        $query = Employee::select('empid');

        if($search != ''){
            $query = $query->where('empid', 'like', '%' .$search. '%');
        }
        $results = $query->distinct('empid')->get();

        $response = [];
        foreach($results as $result){
            $response['results'][] = [
                "id"=>$result->empid,
                "text"=>$result->empid
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

            //Proses upload file photo
            if ($request->hasFile('photo')) {
                $data = $request->file('photo');
                $extension = $data->getClientOriginalExtension();
                $filename = 'employee_' . $request->empid . '.' . $extension;
                $path = public_path('uploads/employee/photos/');
                $employeeImage = public_path("uploads/employee/photos/{$filename}"); // get previous image from folder
                if (File::exists($employeeImage)) { // unlink or remove previous image from folder
                    unlink($employeeImage);
                }
                //save image to project directory
                $data->move($path, $filename);
            } else{ //null filename if request->file('photo') null
                $filename = null;
            }

            $dml = Employee::create([
                'uuid' => Str::uuid(),
                'empid' => $request->empid,
                'fullname' => $request->fullname,
                'nickname' => $request->nickname,
                'photo' => $filename,
                'pob' => $request->pob,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'religion' => $request->religion,
                'mobile01' => $request->mobile01,
                'mobile02' => $request->mobile02,
                'email' => $request->email,
                'bloodtype' => $request->bloodtype,
                'maritalstatus' => $request->maritalstatus,
                'empdate' => $request->empdate,
                'cessdate' => $request->cessdate,
                'probation' => $request->probation,
                'cesscode' => $request->cesscode,
                'recruitby' => $request->recruitby,
                'emptype' => $request->emptype,
                'workgrp' => $request->workgrp,
                'site' => $request->site,
                'accsgrp' => $request->accsgrp,
                'achgrp' => $request->achgrp,
                'jobgrp' => $request->jobgrp,
                'costcode' => $request->costcode,
                'orgcode' => $request->orgcode,
                'orglvl' => $request->orglvl,
                'title' => $request->title,
                'jobtitle' => $request->jobtitle,
                'remark' => $request->remark,
                'status' => $request->status,
                'owned_by' => $request->user()->company_id,
                'created_by' => $request->user()->id,
            ]);
            if ($dml){
                return response()->json(['success' => 'a new Employee added successfully.']);
            }
            return response()->json(['error' => 'Error when creating data!']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Show the specified resource.
     * @param int Employee $employee
     * @return Response
     */
    public function show(Employee $employee)
    {
        return view('humanresources::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int Employee $employee
     * @return Response
     */
    public function edit(Employee $employee)
    {
        return view('humanresources::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int Employee $employee
     * @return Response
     */
    public function update(Request $request, Employee $employee)
    {
        if ($request->ajax()){
            $validationArray = $this->getValidationArray($request);
            unset($validationArray['empid']);
            $validation = $request->validate($validationArray);

            if ($request->hasFile('photo')) {
                //Proses upload file photo
                $data = $request->file('photo');
                $extension = $data->getClientOriginalExtension();
                $filename = 'employee_' . $request->empid . '.' . $extension;
                $path = public_path('uploads/employee/photos/');
                $employeeImage = public_path("uploads/employee/photos/{$filename}"); // get previous image from folder
                if (File::exists($employeeImage)) { // unlink or remove previous image from folder
                    unlink($employeeImage);
                }
                //save image to project directory
                $data->move($path, $filename);
            } else{ //null filename if request->file('photo') null
                $filename = null;
            }

            $dml = Employee::where('id', $employee->id)
                ->first()->update([
//                'empid' => $request->empid,
                'fullname' => $request->fullname,
                'nickname' => $request->nickname,
                'photo' => ( ($filename != null) ? $filename : $employee->photo),
                'pob' => $request->pob,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'religion' => $request->religion,
                'mobile01' => $request->mobile01,
                'mobile02' => $request->mobile02,
                'email' => $request->email,
                'bloodtype' => $request->bloodtype,
                'maritalstatus' => $request->maritalstatus,
                'empdate' => $request->empdate,
                'cessdate' => $request->cessdate,
                'probation' => $request->probation,
                'cesscode' => $request->cesscode,
                'recruitby' => $request->recruitby,
                'emptype' => $request->emptype,
                'workgrp' => $request->workgrp,
                'site' => $request->site,
                'accsgrp' => $request->accsgrp,
                'achgrp' => $request->achgrp,
                'jobgrp' => $request->jobgrp,
                'costcode' => $request->costcode,
                'orgcode' => $request->orgcode,
                'orglvl' => $request->orglvl,
                'title' => $request->title,
                'jobtitle' => $request->jobtitle,
                'remark' => $request->remark,
                'status' => $request->status,
                'owned_by' => $request->user()->company_id,
                'updated_by' => $request->user()->id,
            ]);
            if ($dml){
                return response()->json(['success' => 'an Employee updated successfully.']);
            }
            return response()->json(['error' => 'Error when creating data!']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int Employee $employee
     * @return Response
     */
    public function destroy(Employee $employee)
    {
        //
    }

    //Validation array default for this controller
    public function getValidationArray($request = null){
        $validationArray = [
            'empid' => ['required', 'string', 'max:20', 'alpha_num', 'unique:hr_employees,empid'],
            'fullname' => ['required', 'string', 'max:50'],
            'nickname' => ['required', 'string', 'max:50'],
            'photo' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:1024'],
            'pob' => ['required', 'string', 'max:30'],
            'dob' => ['required', 'date'],
            'gender' => ['required', 'string', 'size:1'],
            'religion' => ['required', 'string', 'max:15'],
            'mobile01' => ['nullable', 'alpha_num', 'digits_between:1,13'],
            'mobile02' => ['nullable', 'alpha_num', 'digits_between:1,13'],
            'email' => ['required', 'string', 'max:50'],
            'bloodtype' => ['required', 'string', 'max:4'],
            'maritalstatus' => ['required', 'string', 'size:1'],
            'empdate' => ['required', 'date'],
            'cessdate' => ['required', 'date'],
            'probation' => ['required', 'string', 'size:1'],
            'cesscode' => ['required', 'string', 'size:2'],
            'recruitby' => ['required', 'string', 'max:4'],
            'emptype' => ['required', 'string', 'size:2'],
            'workgrp' => ['required', 'string', 'max:4'],
            'site' => ['nullable', 'string', 'max:4'],
            'accsgrp' => ['nullable', 'string', 'max:4'],
            'achgrp' => ['nullable', 'string', 'max:4'],
            'jobgrp' => ['nullable', 'string', 'max:4'],
            'costcode' => ['nullable', 'string', 'max:4'],
            'orgcode' => ['required', 'string', 'max:6'],
            'orglvl' => ['required', 'string', 'max:4'],
            'title' => ['required', 'string', 'max:2'],
            'jobtitle' => ['required', 'string', 'max:100'],
            'remark' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'min:0', 'max:1'],
        ];

        return $validationArray;
    }

    public function select2(Request $request)
    {
        $search = $request->q;
        $query = Employee::orderby('fullname','asc')
                        ->select('id','fullname')
                        ->where('company_id', $request->user()->company_id)
                        ->where('status', 1);

        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%');
        }
        $Employees = $query->get();

        $response = [];
        foreach($Employees as $Employee){
            $response['results'][] = [
                "id" => $Employee->id,
                "text" => $Employee->fullname
            ];
        }
        return response()->json($response);
    }
}
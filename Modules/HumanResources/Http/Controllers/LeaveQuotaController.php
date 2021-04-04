<?php

namespace Modules\HumanResources\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\HumanResources\Entities\HrLookup;
use Modules\HumanResources\Entities\LeaveQuota;
use Yajra\DataTables\DataTables;

class LeaveQuotaController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(LeaveQuota::class, 'leave_quotum');
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = LeaveQuota::latest()->get();
            return DataTables::of($data)
                ->addColumn('quotacode', function($row){
                    $query = HrLookup::select('maingrp', 'remark')->where('subkey', 'leave-quota')->where('lkey', 'quotacode')
                        ->where('maingrp', $row->quotacode)->first();
                    $attdtype['content'] = $query->remark;
                    $attdtype['value'] = $query->maingrp;
                    return $attdtype;
                })
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<p class="text-success">Active</p>';
                    } else{
                        return '<p class="text-danger">Inactive</p>';
                    }
                })
                ->addColumn('action', function($row){
                    if( Auth::user()->can('update', LeaveQuota::class) ) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        if (Auth::user()->can('delete', LeaveQuota::class)){
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
        return view('humanresources::pages.leave-quota.index');
    }

    public function select2Quotacode(Request $request)
    {
        $search = $request->q;
        $query = HrLookup::select('maingrp', 'remark')->where('subkey', 'leave-quota')->where('lkey', 'quotacode')
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
        return view('humanresources::pages.leave-quota.index');
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
            date_default_timezone_set('Asia/Jakarta'); //set timezone

            $dml = LeaveQuota::create([
                'uuid' => Str::uuid(),
                'empid' => $request->empidLquota,
                'quotayear' => $request->quotayear,
                'quotacode' => $request->quotacode,
                'quotastartdate' => $request->quotastartdate,
                'quotaexpdate' => $request->quotaexpdate,
                'quotaallocdate' => date("Y-m-d"),
                'quotaqty' => $request->quotaqty,
                'quotabal' => $request->quotaqty,
                'remark' => $request->remark,
                'status' => $request->status,
                'owned_by' => $request->user()->company_id,
                'created_by' => $request->user()->id,
            ]);
            if ($dml){
                return response()->json(['success' => 'a new Leave Quota data added successfully.']);
            }
            return response()->json(['error' => 'Error when creating data!']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Show the specified resource.
     * @param int LeaveQuota $leave_quotum
     * @return Response
     */
    public function show(LeaveQuota $leave_quotum)
    {
        return view('humanresources::pages.leave-quota.index');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int LeaveQuota $leave_quotum
     * @return Response
     */
    public function edit(LeaveQuota $leave_quotum)
    {
        return view('humanresources::pages.leave-quota.index');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int LeaveQuota $leave_quotum
     * @return Response
     */
    public function update(Request $request, LeaveQuota $leave_quotum)
    {
        if ($request->ajax()){
            $validationArray = $this->getValidationArray($request);
            unset($validationArray['empidLquota']);
            unset($validationArray['quotacode']);
            $validation = $request->validate($validationArray);
            date_default_timezone_set('Asia/Jakarta'); //set timezone

            $dml = LeaveQuota::where('id', $leave_quotum->id)
                ->first()->update([
                'uuid' => Str::uuid(),
//                'empid' => $request->empidLquota,
                'quotayear' => $request->quotayear,
//                'quotacode' => $request->quotacode,
                'quotastartdate' => $request->quotastartdate,
                'quotaexpdate' => $request->quotaexpdate,
                'quotaallocdate' => date("Y-m-d"),
                'quotaqty' => $request->quotaqty,
                'quotabal' => $request->quotaqty, // harusnya quotaqty - pemotongan di request
                'remark' => $request->remark,
                'status' => $request->status,
                'owned_by' => $request->user()->company_id,
                'updated_by' => $request->user()->id,
            ]);
            if ($dml){
                return response()->json(['success' => 'a new Leave Quota data updated successfully.']);
            }
            return response()->json(['error' => 'Error when updating data!']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int LeaveQuota $leave_quotum
     * @return Response
     */
    public function destroy(LeaveQuota $leave_quotum)
    {
        $currentRow = LeaveQuota::where('id', $leave_quotum->id)->first();
        LeaveQuota::destroy($leave_quotum->id);
        return response()->json(['success' => 'Contact Data has been Deleted']);
    }

    //Validation array default for this controller
    public function getValidationArray($request){
        $validationArray = [
            'empidLquota' => ['required', 'string', 'max:20'],
            'quotayear' => ['required', 'numeric', 'digits:4'],
            'quotacode' => ['required', 'string', 'size:2'],
            'quotastartdate' => ['date'],
            'quotaexpdate' => ['date', 'after_or_equal:quotastartdate'],
//            'quotaallocdate' => ['date'],
            'quotaqty' => ['required', 'numeric'],
//            'quotabal' => ['required', 'numeric'],
            'remark' => ['nullable','string', 'max:100'],
            'status' => ['required', 'min:0', 'max:1'],
        ];

        return $validationArray;
    }
}

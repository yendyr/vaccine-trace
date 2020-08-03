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

class WorkingGroupDetailController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(WorkingGroupDetail::class, 'workgroup_detail');
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = WorkingGroupDetail::latest()->get();
            return DataTables::of($data)
                ->addColumn('workgroup', function($row){
                    $workname = WorkingGroup::where('workgroup', $row->workgroup)->first()->workname;
                    $workgroup['name'] = $workname;
                    $workgroup['value'] = $row->workgroup;
                    return $workgroup;
                })
                ->addColumn('daycode', function($row){
                    $daycodeArr = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    $daycode['day'] = $daycodeArr[intval($row->daycode-1)];
                    $daycode['value'] = $row->daycode;
                    return $daycode;
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
                ->addColumn('action', function($row){
                    if(Auth::user()->can('update', WorkingGroupDetail::class)) {
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

    public function select2Workgroup(Request $request)
    {
        $search = $request->q;
        $query = WorkingGroup::orderby('workgroup')->select('id','workgroup','workname')->where('status', 1);
        if($search != ''){
            $query = $query->where('workgroup', 'like', '%' .$search. '%');
        }
        $results = $query->get();

        $response = [];
        foreach($results as $result){
            $response['results'][] = [
                "id"=>$result->workgroup,
                "text"=>($result->workgroup .' - '. $result->workname)
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
            $request->validate([
                'workgroup' => ['required', 'string', 'max:4', 'alpha_num', 'unique:working_group_details,workgroup'],
                'daycode' => ['required', 'string', 'size:2'],
                'shiftno' => ['required', 'string', 'size:1'],
                'whtimestart' => ['nullable', 'string', 'max:10'],
                'whtimefinish' => ['nullable', 'string', 'max:10'],
                'rstimestart' => ['nullable', 'string', 'max:10'],
                'rstimefinish' => ['nullable', 'string', 'max:10'],
                'stdhours' => ['nullable', 'numeric'],
                'minhours' => ['nullable', 'numeric'],
                'worktype' => ['required', 'string', 'size:2'],
                'status' => ['required', 'min:0', 'max:1'],
            ]);

            WorkingGroupDetail::create([
                'uuid' => Str::uuid(),
                'workgroup' => $request->workgroup,
                'daycode' => $request->daycode,
                'shiftno' => $request->shiftno,
                'whtimestart' => $request->whtimestart,
                'whtimefinish' => $request->whtimefinish,
                'rstimestart' => $request->rstimestart,
                'rstimefinish' => $request->rstimefinish,
                'stdhours' => $request->stdhours,
                'minhours' => $request->minhours,
                'worktype' => $request->worktype,
                'status' => $request->status,
                'owned_by' => $request->user()->company_id,
                'created_by' => $request->user()->id,
            ]);
            return response()->json(['success' => 'a new Working Group Detail added successfully.']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Show the specified resource.
     * @param int WorkingGroupDetail $workgroup_detail
     * @return Response
     */
    public function show(WorkingGroupDetail $workgroup_detail)
    {
        return view('humanresources::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int WorkingGroupDetail $workgroup_detail
     * @return Response
     */
    public function edit(WorkingGroupDetail $workgroup_detail)
    {
        return view('humanresources::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int WorkingGroupDetail $workgroup_detail
     * @return Response
     */
    public function update(Request $request, WorkingGroupDetail $workgroup_detail)
    {
        if ($request->ajax()){
            $request->validate([
                'workgroup' => ['required', 'string', 'max:4', 'alpha_num'],
                'daycode' => ['required', 'string', 'size:2'],
                'shiftno' => ['required', 'string', 'size:1'],
                'whtimestart' => ['nullable', 'string', 'max:10'],
                'whtimefinish' => ['nullable', 'string', 'max:10'],
                'rstimestart' => ['nullable', 'string', 'max:10'],
                'rstimefinish' => ['nullable', 'string', 'max:10'],
                'stdhours' => ['nullable', 'numeric'],
                'minhours' => ['nullable', 'numeric'],
                'worktype' => ['required', 'string', 'size:2'],
                'status' => ['required', 'min:0', 'max:1'],
            ]);

            WorkingGroupDetail::where('id', $workgroup_detail->id)
                ->update([
                'workgroup' => $request->workgroup,
                'daycode' => $request->daycode,
                'shiftno' => $request->shiftno,
                'whtimestart' => $request->whtimestart,
                'whtimefinish' => $request->whtimefinish,
                'rstimestart' => $request->rstimestart,
                'rstimefinish' => $request->rstimefinish,
                'stdhours' => $request->stdhours,
                'minhours' => $request->minhours,
                'worktype' => $request->worktype,
                'status' => $request->status,
                'owned_by' => $request->user()->company_id,
                'updated_by' => $request->user()->id,
            ]);
            return response()->json(['success' => 'a new Working Group Detail added successfully.']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int WorkingGroupDetail $workgroup_detail
     * @return Response
     */
    public function destroy(WorkingGroupDetail $workgroup_detail)
    {
        //
    }
}

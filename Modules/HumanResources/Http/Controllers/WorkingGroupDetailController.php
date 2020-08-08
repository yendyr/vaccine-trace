<?php

namespace Modules\HumanResources\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
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
            if (isset($request->workgroup)){
                $data = WorkingGroupDetail::latest()->where('workgroup', $request->workgroup)->get();
            } else {
                $data = WorkingGroupDetail::latest()->get();
            }
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

    public function select2Shiftno(Request $request)
    {
        if (isset($request->workgroup)){
            $query = WorkingGroup::select('shiftrolling')->where('workgroup', $request->workgroup)->first();
            $results = $query->shiftrolling;
        }
        $results = str_split($results);

        $response = [];
        foreach($results as $result){
            $response['results'][] = [
                "id"=>$result,
                "text"=>$result
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
            //get Shift No from shiftrolling for validating
            if (isset($request->workgroup)){
                $query = WorkingGroup::select('shiftrolling')->where('workgroup', $request->workgroup)->first()->shiftrolling;
                $shiftno = str_split($query);
            } else{
                $shiftno = '';
            }

            $request->validate([
                'workgroup' => ['required', 'string', 'max:4', 'alpha_num'],
                'daycode' => ['required', 'string', 'size:2',
                    Rule::unique('working_group_details')->where(function ($query) use($request) {
                        return $query->where('daycode', $request->daycode)->where('shiftno', $request->shiftno);
                    })
                ],
                'shiftno' => ['required', 'string', 'size:1',
                    Rule::in($shiftno)
                ],
                'whtimestart' => ['nullable', 'string', 'max:10'],
                'whtimefinish' => ['nullable', 'string', 'max:10'],
                'rstimestart' => ['nullable', 'string', 'max:10'],
                'rstimefinish' => ['nullable', 'string', 'max:10'],
                'stdhours' => ['nullable', 'numeric'],
                'minhours' => ['nullable', 'numeric'],
                'worktype' => ['required', 'string', 'size:2'],
                'status' => ['required', 'min:0', 'max:1'],
            ]);

            //CHANGE TIME FORMAT
            if (isset($request->whtimestart)){
                $time=date_create($request->whtimestart);
                $request->whtimestart = date_format($time,"H:i:s");
            }
            if(isset($request->whtimefinish)){
                $time=date_create($request->whtimefinish);
                $request->whtimefinish = date_format($time,"H:i:s");
            }
            if(isset($request->rstimestart)){
                $time=date_create($request->rstimestart);
                $request->rstimestart = date_format($time,"H:i:s");
            }
            if(isset($request->rstimefinish)){
                $time=date_create($request->rstimefinish);
                $request->rstimefinish = date_format($time,"H:i:s");
            }

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
//                'workgroup' => ['required', 'string', 'max:4', 'alpha_num'],
//                'daycode' => ['required', 'string', 'size:2',
//                    Rule::unique('working_group_details')->where(function ($query) use($request) {
//                        return $query->where('daycode', $request->daycode)->where('shiftno', $request->shiftno);
//                    })
//                ],
//                'shiftno' => ['required', 'string', 'size:1'],
                'whtimestart' => ['nullable', 'string', 'max:10'],
                'whtimefinish' => ['nullable', 'string', 'max:10'],
                'rstimestart' => ['nullable', 'string', 'max:10'],
                'rstimefinish' => ['nullable', 'string', 'max:10'],
                'stdhours' => ['nullable', 'numeric'],
                'minhours' => ['nullable', 'numeric'],
                'worktype' => ['required', 'string', 'size:2'],
                'status' => ['required', 'min:0', 'max:1'],
            ]);

            //CHANGE TIME FORMAT
            if (isset($request->whtimestart)){
                $time=date_create($request->whtimestart);
                $request->whtimestart = date_format($time,"H:i:s");
            }
            if(isset($request->whtimefinish)){
                $time=date_create($request->whtimefinish);
                $request->whtimefinish = date_format($time,"H:i:s");
            }
            if(isset($request->rstimestart)){
                $time=date_create($request->rstimestart);
                $request->rstimestart = date_format($time,"H:i:s");
            }
            if(isset($request->rstimefinish)){
                $time=date_create($request->rstimefinish);
                $request->rstimefinish = date_format($time,"H:i:s");
            }

            WorkingGroupDetail::where('id', $workgroup_detail->id)
                ->update([
//                'workgroup' => $request->workgroup,
//                'daycode' => $request->daycode,
//                'shiftno' => $request->shiftno,
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
            return response()->json(['success' => 'a Working Group Detail updated successfully.']);
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

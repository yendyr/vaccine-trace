<?php

namespace Modules\HumanResources\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Gate\Entities\User;
use Modules\HumanResources\Entities\OrganizationStructure;
use Modules\HumanResources\Entities\OrganizationStructureTitle;
use Yajra\DataTables\Facades\DataTables;

class OrganizationStructureTitleController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
//        $this->authorizeResource(OrganizationStructureTitle::class, 'organization_structure_title');
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('humanresources::pages.os-ost.index');
    }

    public function select2Orgcode(Request $request)
    {
        $search = $request->q;
        $query = OrganizationStructure::orderby('orglevel','asc')->select('id','orgcode', 'orgname')->where('status', 1);
        if($search != ''){
            $query = $query->where('orgname', 'like', '%' .$search. '%');
        }
        $results = $query->get();

        $response = [];
        foreach($results as $result){
            $response['results'][] = [
                "id"=>$result->orgcode,
                "text"=>($result->orgcode .' - '. $result->orgname)
            ];
        };

        return response()->json($response);
    }

    public function select2Rptorg(Request $request)
    {
        $queryOst = OrganizationStructureTitle::distinct()->get(['orgcode']);
        foreach ($queryOst as $i => $queryOstRow){
            $orgcodes[$i] = $queryOstRow->orgcode;
        }

        $search = $request->q;
        $queryOs = OrganizationStructure::orderby('orgcode','asc')->select('orgcode', 'orgname')->where('status', 1);
        if($search != ''){
            $queryOs = $queryOs->where('orgname', 'like', '%' .$search. '%');
        }
        $results = $queryOs->get();

        $response = [];
        $response['results'][] = [
            "id" => 0,
            "text" => 'none',
        ];
        foreach($results as $result){
            if (in_array($result->orgcode, $orgcodes)){
                $response['results'][] = [
                    "id"=>$result->orgcode,
                    "text"=>$result->orgcode . ' - ' . $result->orgname
                ];
            }
        };

        return response()->json($response);
    }

    public function select2Title(Request $request)
    {
        $search = $request->q;
        $query = OrganizationStructureTitle::distinct();
        if($search != ''){
            $query = $query->where('titlecode', 'like', '%' .$search. '%');
        }
        $results = $query->get(['titlecode']);
        $titles = [
            'Kepala', 'Wakil kepala', 'Anggota', 'Staff', 'Operator'
        ];

        $response = [];
        $response['results'][] = [
            "id" => 0,
            "text" => 'none',
        ];
        foreach($results as $result){
            $response['results'][] = [
                "id"=>$result->titlecode,
                "text"=>($titles[$result->titlecode-1])
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
                'orgcode' => ['required', 'string', 'max:255', 'alpha_dash'],
                'titlecode' => ['required', 'string', 'max:2'],
                'jobtitle' => ['required', 'string', 'max:20'],
                'rptorg' => ['string', 'max:255'],
                'rpttitle' => ['string', 'max:2'],
                'status' => ['min:0', 'max:1'],
            ]);

            OrganizationStructureTitle::create([
                'uuid' => Str::uuid(),
                'orgcode' => $request->orgcode,
                'titlecode' => $request->titlecode,
                'jobtitle' => $request->jobtitle,
                'rptorg' => ($request->rptorg == 0 ? null : $request->rptorg),
                'rpttitle' => ($request->rpttitle == 0 ? null : $request->rpttitle),
                'owned_by' => $request->user()->company_id,
                'created_by' => $request->user()->id,
                'status' => $request->status,
            ]);
            return response()->json(['success' => 'a new Organization Structure title added successfully.']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(Request $request, $orgcode)
    {
        if ($request->ajax()) {
            if ($orgcode == null){
                $data = OrganizationStructureTitle::latest()->where('orgcode', null)->get();
            } else {
                $data = OrganizationStructureTitle::latest()->where('orgcode', $orgcode)->get();
            }
            return DataTables::of($data)
                ->addColumn('titlecode', function($row){
                    $titles = [
                        'Kepala', 'Wakil kepala', 'Anggota', 'Staff', 'Operator'
                    ];
                    $title['title'] = $titles[$row->titlecode-1];
                    $title['value'] = $row->titlecode;
                    return $title;
                })
                ->addColumn('rpttitle', function($row){
                    $titles = [
                        'Kepala', 'Wakil kepala', 'Anggota', 'Staff', 'Operator'
                    ];
                    if ($row->rpttitle == 0){
                        return null;
                    }
                    $rpttitle['code'] = $row->rpttitle;
                    $rpttitle['title'] = $titles[$row->rpttitle - 1];
                    return $rpttitle;
                })
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<p class="text-success">Active</p>';
                    } else{
                        return '<p class="text-danger">Inactive</p>';
                    }
                })
                ->addColumn('action', function($row){
//                    if(Auth::user()->can('update', OrganizationStructureTitle::class)) {
                    $updateable = 'button';
                    $updateValue = $row->id;
                    return view('components.action-button', compact(['updateable', 'updateValue']));
//                    }else{
//                        return '<p class="text-muted">no action authorized</p>';
//                    }
                })
                ->addColumn('rptorg', function($row){
                    if ($row->rptorg == null){
                        return null;
                    }
                    $orgidentity['code'] = $row->rptorg;
                    $orgname = OrganizationStructure::select('orgname')->where('orgcode', $row->rptorg)->first();
                    $orgidentity['name'] = $orgname['orgname'];
                    return $orgidentity;
                })
                ->addColumn('orgcode', function($row){
                    $orgidentity['code'] = $row->orgcode;
                    $orgidentity['name'] = OrganizationStructure::select('orgname')->where('orgcode', $row->orgcode)->first()->orgname;
                    return $orgidentity;
                })
                ->escapeColumns([])
                ->make(true);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('humanresources::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, OrganizationStructureTitle $ost)
    {
        if ($request->ajax()){
            $request->validate([
                'orgcode' => ['required', 'string', 'max:255', 'alpha_dash'],
                'titlecode' => ['required', 'string', 'max:2'],
                'jobtitle' => ['required', 'string', 'max:20'],
                'rptorg' => ['string', 'max:255'],
                'rpttitle' => ['string', 'max:2'],
                'status' => ['min:0', 'max:1'],
            ]);

            OrganizationStructureTitle::where('id', $request->id)
                ->update([
                    'orgcode' => $request->orgcode,
                    'titlecode' => $request->titlecode,
                    'jobtitle' => $request->jobtitle,
                    'rptorg' => ($request->rptorg == 0 ? null : $request->rptorg),
                    'rpttitle' => ($request->rpttitle == 0 ? null : $request->rpttitle),
                    'owned_by' => $request->user()->company_id,
                    'updated_by' => $request->user()->id,
                    'status' => $request->status,
                ]);
            return response()->json(['success' => 'an Organization Structure title updated successfully.']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(OrganizationStructureTitle $ost)
    {
        OrganizationStructureTitle::destroy($ost->id);

        return response()->json(['success' => 'Organization Structure title data deleted successfully.']);
    }
}
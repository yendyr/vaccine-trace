<?php

namespace Modules\HumanResources\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\HumanResources\Entities\OrganizationStructure;

class OrganizationStructureController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
//        $this->authorizeResource(OrganizationStructure::class, 'organization_structure');
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

    public function dataJson(){
        $orgData = OrganizationStructure::whereNull('orgparent')->with('childs')->get();
        $dataJson['result'] = $orgData;
        $dataJson['count'] = $orgData->count();

        return response()->json($dataJson);
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
        $response['results'][] = [
            "id" => 0,
            "text" => 'none',
        ];
        foreach($results as $result){
            $response['results'][] = [
                "id"=>$result->orgcode,
                "text"=>($result->orgcode .' - '. $result->orgname)
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
                'orglevel' => ['required', 'integer'],
                'orgcode' => ['required', 'string', 'max:255', 'alpha_dash', 'max:20'],
                'orgparent' => ['string', 'max:255', 'alpha_dash', 'max:20'],
                'orgname' => ['required', 'string', 'max:100'],
                'status' => ['min:0', 'max:1'],
            ]);

            OrganizationStructure::create([
                'uuid' => Str::uuid(),
                'orglevel' => $request->orglevel,
                'orgcode' => $request->orgcode,
                'orgparent' => $request->orgparent,
                'orgname' => $request->orgname,
                'owned_by' => (isset($request->user()->company_id) ? $request->user()->company_id : 0),
                'created_by' => $request->user()->id,
                'status' => $request->status,
            ]);
            return response()->json(['success' => 'a new Organization Structure added successfully.']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('humanresources::show');
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
    public function update(Request $request, OrganizationStructure $os)
    {
        if ($request->ajax()){
            $request->validate([
                'orglevel' => ['required', 'integer'],
                'orgcode' => ['required', 'string', 'max:255', 'alpha_dash', 'max:20'],
                'orgparent' => ['string', 'max:255', 'alpha_dash', 'max:20'],
                'orgname' => ['required', 'string', 'max:100'],
                'status' => ['min:0', 'max:1'],
            ]);

            OrganizationStructure::where('id', $request->id)
                ->update([
                    'orglevel' => $request->orglevel,
                    'orgcode' => $request->orgcode,
                    'orgparent' => $request->orgparent,
                    'orgname' => $request->orgname,
                    'owned_by' => (isset($request->user()->company_id) ? $request->user()->company_id : 0),
                    'updated_by' => $request->user()->id,
                    'status' => $request->status,
                ]);
            return response()->json(['success' => 'an Organization Structure updated successfully.']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}

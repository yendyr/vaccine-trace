<?php

namespace Modules\HumanResources\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\HumanResources\Entities\Address;
use Modules\HumanResources\Entities\Family;
use Modules\HumanResources\Entities\HrLookup;
use Yajra\DataTables\Facades\DataTables;

class AddressController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Address::class, 'address');
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
                $data = Address::latest()->where('empid', $request->empid)->get();
            } else {
                $data = Address::latest()->get();
            }
            return DataTables::of($data)
                ->addColumn('telephone', function($row){
                    $telephone['value1'] = $row->tel01;
                    $telephone['value2'] = $row->tel02;
                    if (isset($row->tel01)){
                        $telephone['content'] = $row->tel01;
                    } else if (isset($row->tel02)){
                        $telephone['content'] = $row->tel02;
                    } else if(isset($row->tel01) && isset($row->tel02)){
                        $telephone['content'] = $row->tel01 . ', ' . $row->tel02;
                    }
                    return $telephone;
                })
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<p class="text-success">Active</p>';
                    } else{
                        return '<p class="text-danger">Inactive</p>';
                    }
                })
                ->addColumn('action', function($row){
                    if(Auth::user()->can('update', Address::class)) {
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



    public function select2Famid(Request $request)
    {
        $search = $request->q;
        if (isset($request->empid)){
            $queries = Family::select('famid')->where('empid', $request->empid);
            if($search != ''){
                $queries = $queries->where('famid', 'like', '%' .$search. '%');
            }
            $queries = $queries->where('status', 1)->get();

            if (count($queries) > 0){
                foreach ($queries as $query){
                    $results[] = $query->famid;
                }
            }
            $results[] = $request->empid;
        }

        $response = [];
        if (isset($results)){
            foreach($results as $result){
                $response['results'][] = [
                    "id"=>$result,
                    "text"=>$result
                ];
            };
        }else {
            $response = null;
        }

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

            $dml = Address::create([
                'uuid' => Str::uuid(),
                'empid' => $request->empidAddress,
                'famid' => $request->famidAddress,
                'addrid' => $request->addrid,
                'street' => $request->street,
                'area' => $request->area,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'postcode' => $request->postcode,
                'tel01' => $request->tel01,
                'tel02' => $request->tel02,
                'remark' => $request->remark,
                'status' => $request->status,
                'owned_by' => $request->user()->company_id,
                'created_by' => $request->user()->id,
            ]);
            if ($dml){
                return response()->json(['success' => 'a new Address data added successfully.']);
            }
            return response()->json(['error' => 'Error when creating data!']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Show the specified resource.
     * @param int Address $address
     * @return Response
     */
    public function show(Address $address)
    {
        return view('humanresources::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int Address $address
     * @return Response
     */
    public function edit(Address $address)
    {
        return view('humanresources::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int Address $address
     * @return Response
     */
    public function update(Request $request, Address $address)
    {
        if ($request->ajax()){
            $validationArray = $this->getValidationArray($request);
            unset($validationArray['empidAddress']);
            unset($validationArray['famidAddress']);
            unset($validationArray['addrid']);
            $validation = $request->validate($validationArray);

            $dml = Address::where('id', $address->id)
                ->first()->update([
//                'empid' => $request->empidAddress,
//                'famid' => $request->famidAddress,
//                'addrid' => $request->addrid,
                'street' => $request->street,
                'area' => $request->area,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'postcode' => $request->postcode,
                'tel01' => $request->tel01,
                'tel02' => $request->tel02,
                'remark' => $request->remark,
                'status' => $request->status,
                'owned_by' => $request->user()->company_id,
                'updated_by' => $request->user()->id,
            ]);
            if ($dml){
                return response()->json(['success' => 'an Address data updated successfully.']);
            }
            return response()->json(['error' => 'Error when updating data!']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int Address $address
     * @return Response
     */
    public function destroy(Address $address)
    {
        //
    }

    //Validation array default for this controller
    public function getValidationArray($request){
        $validationArray = [
            'empidAddress' => ['required', 'string', 'max:20'],
            'famidAddress' => ['required', 'string', 'max:20'],
            'addrid' => ['required', 'string', 'max:20'],
            'street' => ['required', 'string'],
            'area' => ['required', 'string', 'max:30'],
            'city' => ['required', 'string', 'max:30'],
            'state' => ['required', 'string', 'max:30'],
            'country' => ['required', 'string', 'max:30'],
            'postcode' => ['required', 'string', 'max:10'],
            'tel01' => ['nullable', 'string', 'max:20'],
            'tel02' => ['nullable', 'string', 'max:20'],
            'remark' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'min:0', 'max:1'],
        ];
        return $validationArray;
    }
}

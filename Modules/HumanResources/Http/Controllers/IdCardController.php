<?php

namespace Modules\HumanResources\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Modules\HumanResources\Entities\Employee;
use Modules\HumanResources\Entities\IdCard;
use Yajra\DataTables\Facades\DataTables;

class IdCardController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(IdCard::class, 'id_card');
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
                $data = IdCard::latest()->where('empid', $request->empid)->get();
            } else {
                $data = IdCard::latest()->get();
            }
            return DataTables::of($data)
                ->addColumn('idcardtype', function($row){
                    $idcardtypes = ['KTP', 'SIM', 'Passport', 'NPWP'];
                    $idcardtype['value'] = $row->idcardtype;
                    $idcardtype['content'] = $idcardtypes[($row->idcardtype-1)];
                    return $idcardtype;
                })
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<p class="text-success">Active</p>';
                    } else{
                        return '<p class="text-danger">Inactive</p>';
                    }
                })
                ->addColumn('action', function($row){
                    if(Auth::user()->can('update', IdCard::class)) {
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

            $dml = IdCard::create([
                'uuid' => Str::uuid(),
                'empid' => $request->empid,
                'idcardtype' => $request->idcardtype,
                'idcardno' => $request->idcardno,
                'idcarddate' => $request->idcarddate,
                'idcardexpdate' => $request->idcardexpdate,
                'status' => $request->status,
                'owned_by' => $request->user()->company_id,
                'created_by' => $request->user()->id,
            ]);
            if ($dml){
                return response()->json(['success' => 'a new Id Card added successfully.']);
            }
            return response()->json(['error' => 'Error when creating data!']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(IdCard $id_card)
    {
        return view('humanresources::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(IdCard $id_card)
    {
        return view('humanresources::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, IdCard $id_card)
    {
        if ($request->ajax()){
            $validationArray = $this->getValidationArray($request);
            $validationArray['idcardno'] = ['required', 'string', 'max:20',
                Rule::unique('id_cards')->where(function ($query) use ($request, $id_card) {
                    return $query->where('idcardtype', $request->idcardtype)
                        ->where('idcardno', $request->idcardno);
                })->ignore($id_card->id)
            ];
            unset($validationArray['empid']);

            $validation = $request->validate($validationArray);

            $dml = IdCard::where('id', $id_card->id)
                ->update([
//                'empid' => $request->empid,
                'idcardtype' => $request->idcardtype,
                'idcardno' => $request->idcardno,
                'idcarddate' => $request->idcarddate,
                'idcardexpdate' => $request->idcardexpdate,
                'status' => $request->status,
                'owned_by' => $request->user()->company_id,
                'updated_by' => $request->user()->id,
            ]);
            if ($dml){
                return response()->json(['success' => 'an Id Card updated successfully.']);
            }
            return response()->json(['error' => 'Error when creating data!']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int IdCard $id_card
     * @return Response
     */
    public function destroy(IdCard $id_card)
    {
        //
    }

    //Validation array default for this controller
    public function getValidationArray($request){
        $validationArray = [
            'empid' => ['required', 'string', 'max:20'],
            'idcardtype' => ['required', 'string', 'max:2'],
            'idcardno' => ['required', 'string', 'max:20',
                Rule::unique('id_cards')->where(function ($query) use($request) {
                    return $query->where('empid', $request->empid)
                        ->where('idcardtype', $request->idcardtype)
                        ->where('idcardno', $request->idcardno);
                })],
            'idcarddate' => ['required', 'date'],
            'idcardexpdate' => ['required', 'date'],
            'status' => ['required', 'min:0', 'max:1'],
        ];

        return $validationArray;
    }
}

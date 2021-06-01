<?php

namespace Modules\GeneralSetting\Http\Controllers;

use Modules\GeneralSetting\Entities\Country;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Country::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Country::all();
            
            return Datatables::of($data)
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<label class="label label-success">Active</label>';
                    } else{
                        return '<label class="label label-danger">Inactive</label>';
                    }
                })
                ->addColumn('creator_name', function($row){
                    return $row->creator->name ?? '-';
                })
                ->addColumn('updater_name', function($row){
                    return $row->updater->name ?? '-';
                })
                ->addColumn('action', function($row){
                    $noAuthorize = true;
                    if(Auth::user()->can('update', Country::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', Country::class)) {
                        $deleteable = true;
                        $deleteId = $row->id;
                        $noAuthorize = false;
                    }

                    if ($noAuthorize == false) {
                        return view('components.action-button', compact(['updateable', 'updateValue','deleteable', 'deleteId']));
                    }
                    else {
                        return '<p class="text-muted font-italic">Not Authorized</p>';
                    }
                    
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('generalsetting::pages.country.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        Country::create([
            'iso' => $request->iso,
            'iso_3' => $request->iso_3,
            'name' => $request->name,
            'nice_name' => $request->nice_name,
            'num_code' => $request->num_code,
            'phone_code' => $request->phone_code,
            'description' => $request->description,
            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Country Data has been Added']);
    
    }

    public function show(Country $Country)
    {
        return view('generalsetting::pages.country.show');
    }

    public function edit(Country $Country)
    {
        return view('generalsetting::pages.country.edit', compact('Country'));
    }

    public function update(Request $request, Country $Country)
    {
        $request->validate([
            'name' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        $currentRow = Country::where('id', $Country->id)->first();
        $currentRow->update([
                'iso' => $request->iso,
                'iso_3' => $request->iso_3,
                'name' => $request->name,
                'nice_name' => $request->nice_name,
                'num_code' => $request->num_code,
                'phone_code' => $request->phone_code,
                'description' => $request->description,
                'status' => $status,
            ]);
        
        return response()->json(['success' => 'Country Data has been Updated']);
    
    }

    public function destroy(Country $Country)
    {
        $currentRow = Country::where('id', $Country->id)->first();
        $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        Country::destroy($Country->id);
        return response()->json(['success' => 'Country Data has been Deleted']);
    }

    public function select2(Request $request)
    {
        $search = $request->q;
        $query = Country::orderby('nice_name','asc')
                        ->select('id','nice_name')
                        ->where('status', 1);

        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%');
        }
        $Countries = $query->get();

        $response = [];
        foreach($Countries as $Country){
            $response['results'][] = [
                "id"=>$Country->id,
                "text"=>$Country->nice_name
            ];
        }

        return response()->json($response);
    }
}
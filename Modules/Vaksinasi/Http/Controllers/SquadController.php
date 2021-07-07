<?php

namespace Modules\Vaksinasi\Http\Controllers;

use Modules\Vaksinasi\Entities\Squad;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class SquadController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Squad::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Squad::all();

            return Datatables::of($data)
            ->addColumn('status', function($row) {
                if ($row->status == 1) {
                    return '<label class="label label-success">Active</label>';
                } 
                else {
                    return '<label class="label label-danger">Inactive</label>';
                }
            })
            ->addColumn('creator_name', function($row) {
                return $row->creator->name ?? '-';
            })
            ->addColumn('updater_name', function($row) {
                return $row->updater->name ?? '-';
            })
            ->addColumn('action', function($row) {
                $noAuthorize = true;
                if(Auth::user()->can('update', Squad::class)) {
                    $updateable = 'button';
                    $updateValue = $row->id;
                    $noAuthorize = false;
                }
                if(Auth::user()->can('delete', Squad::class)) {
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
        return view('vaksinasi::pages.squad.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'max:30', 'unique:item_categories,code'],
            'name' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        Squad::create([
            'uuid' =>  Str::uuid(),
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'vaccine_target' => $request->vaccine_target,

            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Data Satuan Berhasil Ditambahkan']);    
    }

    public function update(Request $request, Squad $Squad)
    {
        $request->validate([
            'code' => ['required', 'max:30'],
            'name' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        if ( $Squad->code == $request->code) {
            $Squad->update([
                'code' => $request->code,
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'vaccine_target' => $request->vaccine_target,

                'status' => $status,
                'updated_by' => Auth::user()->id,
            ]);
        }
        else {
            $Squad->update([
                'code' => $request->code,
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'vaccine_target' => $request->vaccine_target,

                'status' => $status,
                'updated_by' => Auth::user()->id,
            ]);
        }
        return response()->json(['success' => 'Data Satuan Berhasil Diubah']);    
    }
    
    public function destroy(Squad $Squad)
    {
        $Squad->update([
            'deleted_by' => Auth::user()->id,
        ]);

        Squad::destroy($Squad->id);
        return response()->json(['success' => 'Data Satuan Berhasil Dihapus']);
    }

    public function select2(Request $request)
    {
        $search = $request->q;

        $query = Squad::orderby('name','asc')
                    ->select('id','name')
                    ->where('status', 1);

        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%');
        }
        $Squads = $query->get();

        $response = [];
        foreach($Squads as $Squad){
            $response['results'][] = [
                "id" => $Squad->id,
                "text" => $Squad->name
            ];
        }
        return response()->json($response);
    }
}
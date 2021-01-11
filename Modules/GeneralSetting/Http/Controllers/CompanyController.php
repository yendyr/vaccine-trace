<?php

namespace Modules\GeneralSetting\Http\Controllers;

use Modules\GeneralSetting\Entities\Company;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Company::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Company::all();
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
                    if(Auth::user()->can('update', Company::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', Company::class)) {
                        $deleteable = true;
                        $deleteId = $row->id;
                        $noAuthorize = false;
                    }

                    if ($noAuthorize == false) {
                        return view('components.action-button', compact(['updateable', 'updateValue','deleteable', 'deleteId']));
                    }
                    else {
                        return '<p class="text-muted">Not Authorized</p>';
                    }
                    
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('generalsetting::pages.company.index');
    }

    public function create()
    {
        return view('generalsetting::pages.company.create');
    }

    public function store(Request $request)
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

        Country::create([
            'uuid' => Str::uuid(),
            'code' => $request->code,
            'name' => $request->name,
            'gst_number' => $request->gst_number,
            'npwp_number' => $request->npwp_number,
            'description' => $request->description,
            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Company Data has been Added']);
    
    }

    public function show(Company $Company)
    {
        return view('generalsetting::pages.company.show');
    }

    public function edit(Company $Company)
    {
        return view('generalsetting::pages.company.edit', compact('Company'));
    }

    public function update(Request $request, Company $Company)
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

        $currentRow = Company::where('id', $Company->id)->first();
        $currentRow->update([
                'uuid' => Str::uuid(),
                'code' => $request->code,
                'name' => $request->name,
                'gst_number' => $request->gst_number,
                'npwp_number' => $request->npwp_number,
                'description' => $request->description,
                'owned_by' => $request->user()->company_id,
                'status' => $status,
                'updated_by' => $request->user()->id,
            ]);
        
        return response()->json(['success' => 'Company Data has been Updated']);
    
    }

    public function destroy(Company $Company)
    {
        Company::destroy($Company->id);
        return response()->json(['success' => 'Data Deleted Successfully']);
    }

}
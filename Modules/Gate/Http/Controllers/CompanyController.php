<?php

namespace Modules\Gate\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Company;
use Yajra\DataTables\DataTables;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CompanyController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Company::class, 'company');
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
//        $this->authorize('viewAny', Company::class);
        if ($request->ajax()) {
            $data = Company::latest()->get();
            return Datatables::of($data)
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<p class="text-success">Active</p>';
                    } else{
                        return '<p class="text-danger">Inactive</p>';
                    }
                })
                ->addColumn('action', function($row){
                    if(Auth::user()->can('update', Company::class)) {
                        $updateable = 'a';
                        $href = 'company/' . $row->id . '/edit';
                        return view('components.action-button', compact(['updateable', 'href']));
                    }
                    return '<p class="text-muted">no action authorized</p>';
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('gate::pages.company.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('gate::pages.company.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'max:255', 'alpha_dash', 'unique:companies'],
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email:rfc,dns', 'max:255', 'unique:companies'],
            'remark' => ['required', 'max:255'],
            'status' => ['required', 'min:0', 'max:1']
        ]);

        Company::create([
            'uuid' =>  Str::uuid(),
            'code' => $request->code,
            'company_name' => $request->name,
            'email' => $request->email,
            'remark' => $request->remark,
            'owned_by' => $request->user()->company_id,
            'status' => $request->status,
            'created_by' => $request->user()->id,
        ]);

        return redirect('/gate/company')->with('status', 'a Company data has been added!');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(Company $company)
    {
        return view('gate::pages.company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Company $company)
    {
        return view('gate::pages.company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'code' => ['required', 'max:255', 'alpha_dash'],
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'remark' => ['required', 'max:255'],
            'status' => ['required', 'min:0', 'max:1']
        ]);

        Company::where('id', $company->id)
            ->update([
                'company_name' => $request->name,
                'code' => $request->code,
                'email' => $request->email,
                'remark' => $request->remark,
                'status' => $request->status,
                'updated_by' => $request->user()->id
            ]);

        return redirect('/gate/company')->with('status', 'a Company data has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Company $company)
    {
        Company::destroy($company->id);
        return response()->json(['success' => 'User data deleted successfully.']);
    }
}

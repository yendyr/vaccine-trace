<?php

namespace Modules\Gate\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Company;

class CompanyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $companies = Company::all();
        return view('gate::pages.company.index', compact('companies'));
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
            'code' => ['required', 'max:255', 'alpha_dash'],
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'remark' => ['required', 'max:255'],
        ]);

        Company::create([
            'uuid' =>  Str::uuid(),
            'name' => $request->name,
            'code' => $request->code,
            'email' => $request->email,
            'remark' => $request->remark,
            'owned_by' => $request->user()->company_id,
            'status' => 1,
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
            'code' => ['required', 'max:255'],
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'remark' => ['required', 'max:255'],
        ]);

        Company::where('id', $company->id)
            ->update([
                'name' => $request->name,
                'code' => $request->code,
                'email' => $request->email,
                'remark' => $request->remark,
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
        return redirect('/gate/company')->with('status', 'a Company data has been deleted!');
    }
}

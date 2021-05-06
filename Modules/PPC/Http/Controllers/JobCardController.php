<?php

namespace Modules\PPC\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\PPC\Entities\WorkOrderWorkPackageTaskcard;
use Yajra\DataTables\Facades\DataTables;

class JobCardController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(WorkOrderWorkPackageTaskcard::class, 'job_card');
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        return view('ppc::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        return view('ppc::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param WorkOrderWorkPackageTaskcard $job_card
     * @return Renderable
     */
    public function show(WorkOrderWorkPackageTaskcard $job_card)
    {
        return view('ppc::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param WorkOrderWorkPackageTaskcard $job_card
     * @return Renderable
     */
    public function edit(WorkOrderWorkPackageTaskcard $job_card)
    {
        return view('ppc::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param WorkOrderWorkPackageTaskcard $job_card
     * @return Renderable
     */
    public function update(Request $request, WorkOrderWorkPackageTaskcard $job_card)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param WorkOrderWorkPackageTaskcard $job_card
     * @return Renderable
     */
    public function destroy(WorkOrderWorkPackageTaskcard $job_card)
    {
        //
    }
}

<?php

namespace Modules\Gate\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Role;
use Yajra\DataTables\DataTables;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RoleController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::latest()->get();
            return Datatables::of($data)
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<p class="text-success">Active</p>';
                    } else{
                        return '<p class="text-danger">Inactive</p>';
                    }
                })
                ->addColumn('action', function($row){
                    if(Auth::user()->can('update', Role::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        return view('components.action-button', compact(['updateable', 'updateValue']));
                    }
                    return '<p class="text-muted">no action authorized</p>';
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('gate::pages.role.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('gate::pages.role.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => ['required', 'string', 'max:255'],
            'status' => ['min:0', 'max:1'],
        ]);

        Role::create([
            'uuid' => Str::uuid(),
            'role_name' => $request->role_name,
            'owned_by' => $request->user()->company_id,
            'created_by' => $request->user()->id,
            'status' => $request->status,
        ]);

        return response()->json(['success' => 'a new role added successfully.']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(Role $role)
    {
        return view('gate::pages.role.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Role $role)
    {
        return view('gate::pages.role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'role_name' => ['required', 'string', 'max:255'],
            'status' => ['min:0', 'max:1'],
        ]);

        Role::where('id', $role->id)
            ->update([
                'role_name' => $request->role_name,
                'status' => $request->status,
                'updated_by' => $request->user()->id,
            ]);

        return response()->json(['success' => 'Role data updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Role $role)
    {
        Role::destroy($role->id);

        return response()->json(['success' => 'Role data deleted successfully.']);
    }
}

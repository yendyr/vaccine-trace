<?php

namespace Modules\Gate\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<button class="editBtn btn btn-sm btn-outline btn-primary pr-1 mr-2" value="'.$row->id.'">
                    <i class="fa fa-edit"> Edit </i></button>';
                    $btn .= '<button type="button" name="delete" class="deleteBtn btn btn-sm btn-outline btn-danger pr-1" value="' .$row->id. '">
                            <i class="fa fa-trash"> Delete </i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
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
        ]);

        Role::create([
            'uuid' => Str::uuid(),
            'role_name' => $request->role_name,
            'owned_by' => $request->user()->company_id,
            'created_by' => $request->user()->id,
            'status' => 1,
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
        ]);

        Role::where('id', $role->id)
            ->update([
                'role_name' => $request->role_name,
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

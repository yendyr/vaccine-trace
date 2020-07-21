<?php

namespace Modules\Gate\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Company;
use Modules\Gate\Entities\Role;
use Modules\Gate\Entities\User;
use Modules\Gate\Rules\MatchOldPassword;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with(['role:id,role_name', 'company:id,company_name'])
                ->select('id', 'username', 'email', 'name', 'password', 'role_id', 'company_id', 'status');
            return Datatables::of($data)
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<p class="text-success">Active</p>';
                    } else{
                        return '<p class="text-danger">Inactive</p>';
                    }
                })
                ->addColumn('action', function($row){
                    if(Auth::user()->can('update', User::class)) {
                        return '<button class="editBtn btn btn-sm btn-outline btn-primary pr-1 mr-2" value="' . $row->id . '">
                                <i class="fa fa-edit"> Edit </i></button>';
                    }else{
                        return '<p class="text-muted">no action authorized</p>';
                    }
                })
                ->addColumn('password', function($row){
                    return $row->password;
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('gate::pages.user.index');
    }

    public function select2Company(Request $request)
    {
        $search = $request->q;
        $query = Company::orderby('company_name','asc')->select('id','company_name')->where('status', 1);
        if($search != ''){
            $query = $query->where('company_name', 'like', '%' .$search. '%');
        }
        $companies = $query->get();

        $response = [];
        foreach($companies as $company){
            $response['results'][] = [
                "id"=>$company->id,
                "text"=>$company->company_name
            ];
        }
        $response['results'][] = [
            "id" => 0,
            "text" => 'none',
        ];

        return response()->json($response);
    }

    public function select2Role(Request $request)
    {
        $search = $request->q;
        $query = Role::orderby('role_name','asc')->select('id','role_name')->where('status', 1);
        if($search != ''){
            $query = $query->where('role_name', 'like', '%' .$search. '%');
        }
        $roles = $query->get();

        $response = [];
        foreach($roles as $role){
            $response['results'][] = [
                "id"=>$role->id,
                "text"=>$role->role_name
            ];
        }

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $roles = Role::pluck('role_name', 'id');
        $companies = Company::pluck('company_name', 'id');
        return view('gate::pages.user.create', compact(['roles', 'companies']));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc,dns', 'max:255', 'unique:users'],
            'role' => ['required', 'integer'],
            'company' => ['required', 'integer'],
            'status' => ['min:0', 'max:1'],
        ]);

        User::create([
            'uuid' =>  Str::uuid(),
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role,
            'company_id' => $request->company,
            'owned_by' => $request->company,
            'status' => $request->status,
            'created_by' => $request->user()->id,
        ]);

        return response()->json(['success' => 'a new user added successfully.']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(User $user)
    {
        return view('gate::pages.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('role_name', 'id');
        $companies = Company::pluck('company_name', 'id');
        return view('gate::pages.user.edit', compact(['user', 'roles', 'companies']));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        if ($user->password == $request->password) {
            $request->merge(['password' => $user->password]);
        }else {
            $request->merge(['password' => Hash::make($request->password)]);
        }

        $request->validate([
            'username' => ['required','string', 'max:255', 'alpha_dash'],
            'name' => ['required','string', 'max:255'],
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'role' => ['required', 'integer'],
            'company' => ['required', 'integer'],
            'status' => ['min:0', 'max:1'],
        ]);

        User::where('id', $user->id)
            ->update([
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role_id' => $request->role,
                'company_id' => $request->company,
                'owned_by' => $request->company,
                'status' => $request->status,
                'updated_by' => $request->user()->id
            ]);

        return response()->json(['success' => 'User data updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);

        return response()->json(['success' => 'User data deleted successfully.']);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current' => ['required', new MatchOldPassword()],
            'new' => ['required', 'string', 'max:255'],
            'confirm' => ['same:new'],
        ]);

        User::where('id', $request->user()->id)
            ->update([
                'password' => Hash::make($request->new),
                'updated_by' => $request->user()->id
            ]);

        return response()->json(['success' => 'Your password successfully changed!']);
    }
}

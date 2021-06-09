<?php

namespace Modules\Gate\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Modules\GeneralSetting\Entities\Company;
use Modules\Gate\Entities\Role;
use Modules\Gate\Entities\User;
use Modules\Gate\Rules\MatchOldPassword;
use Modules\HumanResources\Entities\Employee;

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
            $data = User::with(['role:id,role_name', 'company:id,name', 'employee:id,fullname']);

            return Datatables::of($data)
            ->addColumn('status', function($row){
                if ($row->status == 1){
                    return '<label class="label label-success">Active</label>';
                } 
                else {
                    return '<label class="label label-danger">Inactive</label>';
                }
            })
            ->addColumn('action', function($row){
                if(Auth::user()->can('update', User::class)) {
                    $updateable = 'button';
                    $updateValue = $row->id;
                    return view('components.action-button', compact(['updateable', 'updateValue']));
                }
                return '<p class="text-muted font-italic">Not Authorized</p>';
            })
            ->addColumn('password', function($row){
                return $row->password;
            })
            ->escapeColumns([])
            ->make(true);
        }

        return view('gate::pages.user.index');
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
        return view('gate::pages.user.create', compact(['roles', 'companies']));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'username' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:users'],
                'name' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email:rfc,dns', 'max:255', 'unique:users'],
                'role' => ['required', 'integer'],
            ]);

            if ($request->status) {
                $status = 1;
            } 
            else {
                $status = 0;
            }

            if ($request->employee_id) {
                $employee = Employee::where('id', $request->employee_id)
                                    ->select('company_id')
                                    ->first();
                                    
                $company_id = $employee->company_id;
            } 
            else {
                $company_id = $request->company_id;
            }

            User::create([
                'uuid' => Str::uuid(),
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role,
                'employee_id' => $request->employee_id,
                'company_id' => $company_id,
                'status' => $status,
                'created_by' => $request->user()->id,
            ]);
        }
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
        if ($request->ajax()) {
            if ($user->password == $request->password) {
                $request->merge(['password' => $user->password]);
            } else {
                $request->merge(['password' => Hash::make($request->password)]);
            }

            $request->validate([
                'username' => ['required', 'string', 'max:255', 'alpha_dash'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email:rfc,dns', 'max:255'],
                'password' => ['required', 'string', 'max:255'],
                'role' => ['required', 'integer'],
            ]);

            if ($request->status) {
                $status = 1;
            } 
            else {
                $status = 0;
            }

            if ($request->employee_id) {
                $employee = Employee::where('id', $request->employee_id)
                                    ->select('company_id')
                                    ->first();

                $company_id = $employee->company_id;
            } 
            else {
                $company_id = $request->company_id;
            }

            User::where('id', $user->id)
                ->first()->update([
                    'username' => $request->username,
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password,
                    'role_id' => $request->role,
                    'employee_id' => $request->employee_id,
                    'company_id' => $company_id,
                    'status' => $status,
                    'updated_by' => $request->user()->id
                ]);
        }
        return response()->json(['success' => 'User Data has been Updated']);
    }

    public function uploadImage(Request $request){
        if($request->ajax()) {
            $data = $request->file('file');
            $extension = $data->getClientOriginalExtension();
            $filename = 'user_' . $request->user()->username . '.' . $extension;
            $path = public_path('uploads/user/img/');

            $usersImage = public_path("uploads/user/img/{$filename}"); // get previous image from folder

            if (File::exists($usersImage)) { // unlink or remove previous image from folder
                unlink($usersImage);
                $successText = 'Your profile picture successfully changed!';
            } else {
                $successText = 'Your profile picture successfully uploaded!';
            }

            User::where('id', $request->user()->id)
                ->first()->update([
                    'image' => $filename,
                    'updated_by' => $request->user()->id
                ]);

            $data->move($path, $filename);

            return response()->json(['success' => $successText]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(User $User)
    {
        $currentRow = User::where('id', $User->id)->first();
        $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        User::destroy($User->id);
        return response()->json(['success' => 'User Data has been Deleted']);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current' => ['required', new MatchOldPassword()],
            'new' => ['required', 'string', 'max:255'],
            'confirm' => ['same:new'],
        ]);

        User::where('id', $request->user()->id)
            ->first()->update([
                'password' => Hash::make($request->new),
                'updated_by' => $request->user()->id
            ]);

        return response()->json(['success' => 'Your password successfully changed!']);
    }
}

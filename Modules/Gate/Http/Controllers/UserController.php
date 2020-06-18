<?php

namespace Modules\Gate\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Company;
use Modules\Gate\Entities\Role;
use Modules\Gate\Entities\User;

class UserController extends Controller
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
        $users = User::all();
        return view('gate::pages.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $roles = Role::pluck('role_name', 'id');
        $companies = Company::pluck('name', 'id');
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
            'username' => ['required', 'string', 'max:255', 'alpha_dash'],
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'role' => ['required', 'int'],
            'company' => ['int'],
        ]);

        $user = new User();
        $user->uuid = Str::uuid();
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->company = $request->company;
        $user->owned_by = $request->company;
        $user->status = 1;
        $user->password = Hash::make('$request->username');
        $user->created_by = $request->user()->id;
        $user->save();

        return redirect('/gate/user')->with('status', 'User data has been added!');
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
        $companies = Company::pluck('name', 'id');
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
        $request->validate([
            'username' => ['required','string', 'max:255', 'alpha_dash'],
            'name' => ['required','string', 'max:255'],
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'role' => ['required', 'integer'],
        ]);

        User::where('id', $user->id)
            ->update([
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'updated_by' => $request->user()->id
            ]);

        return redirect('/gate/user')->with('status', 'User data has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect('/gate/user')->with('status', 'User data has been deleted!');
    }
}

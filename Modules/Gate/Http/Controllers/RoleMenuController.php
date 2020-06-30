<?php

namespace Modules\Gate\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Menu;
use Modules\Gate\Entities\Role;
use Modules\Gate\Entities\RoleMenu;

class RoleMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $menus = Menu::all();
        $role = Role::pluck('role_name', 'id');
        $roleId = null;

        return view('gate::pages.role-menu.index', compact(['role', 'menus', 'roleId']));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $role = Role::pluck('role_name', 'id');
        $parent = Menu::select('parent')->distinct()->get();
        $menu = DB::table('menus')->select('id', 'menu_text', 'menu_link')->get();
        return view('gate::pages.role-menu.create', compact(['menu', 'role', 'parent']));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $collection = RoleMenu::where('role_id', $request->role)->get(['id']);
        RoleMenu::destroy($collection->toArray());

        for ($i = 0; $i <= count($request['menu']); $i++){
            if (isset($request->index[$i])){
                $queryMenu = DB::table('menus')->select('menu_link')->where('id', $request->menu[$i])->first();
                $create = RoleMenu::create([
                    'uuid' => Str::uuid(),
                    'role_id' => $request->role,
                    'menu_id' => $request->menu[$i],
                    'menu_link' => $queryMenu->menu_link,
                    'add' => ( isset($request->add[$i]) ? intval($request->add[$i]) : 0),
                    'edit' => ( isset($request->edit[$i]) ? intval($request->edit[$i]) : 0),
                    'delete' => ( isset($request->delete[$i]) ? intval($request->delete[$i]) : 0),
                    'status' => 1,
                    'owned_by' => $request->user()->company_id,
                    'created_by' => $request->user()->id,
                ]);
            }
        }

        return redirect('/gate/role-menu')->with('status', "Role menu's data has been updated!");
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($roleId)
    {
        $roleMenus = DB::table('role_menus')->get()->where('role_id', $roleId);;
        $menuIds = DB::table('role_menus')->select('menu_id')->where('role_id', $roleId)->distinct()->get();

        if (count($menuIds) == 0){
            $menuID = null;
        } else{
            $i=0;
            foreach ($menuIds as $menuId){
                $menuID[$i] = $menuId->menu_id;
                $i++;
            }
        }

        $menus = Menu::all();
        $role = Role::pluck('role_name', 'id');

        return view('gate::pages.role-menu.index', compact(['roleMenus', 'role', 'menus', 'roleId', 'menuID']));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(RoleMenu $roleMenu)
    {
        $role = Role::where('id', $roleMenu->role_id)->first();
        $menu = DB::table('menus')->select('id', 'menu_text', 'menu_link')->get();

        $selectedRoleId = DB::table('role_menus')->select('role_id')->where('id', $roleMenu->id)->first();
        //first karena hanya get 1 row dgn role_id yg bersangkutan
        $selectedRoleMenus = DB::table('role_menus')->where('role_id', $selectedRoleId->role_id)->get();

        $i = 0;
        foreach ($selectedRoleMenus as $selectedRoleMenu){
            $parent = DB::table('menus')->select('parent')->where('id', $selectedRoleMenu->menu_id)->first();
            $parents[$i] = null;
            if (!in_array($parent, $parents)){
                $parents[$i] = $parent;
                $i++;
            }
        }

        return view('gate::pages.role-menu.edit', compact(['roleMenu', 'role', 'parents', 'selectedRoleMenus']));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, RoleMenu $roleMenu)
    {
        dd($request->all());
        $request->validate([
            'role' => ['required', 'integer'],
            'menu' => ['required', 'integer'],
            'add' => ['integer'],
            'edit' => ['integer'],
            'delete' => ['integer'],
        ]);

        $menu = Menu::all()->find($request->menu);

        RoleMenu::where('id', $roleMenu->id)
            ->update([
                'role_id' => $request->role,
                'menu_id' => $request->menu,
                'menu_link' => $menu->menu_link,
                'add' => intval($request->add),
                'edit' => intval($request->edit),
                'delete' => intval($request->delete),
                'updated_by' => $request->user()->id,
            ]);

        return redirect('/gate/role-menu')->with('status', 'a role-menu data has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(RoleMenu $roleMenu)
    {
        RoleMenu::destroy($roleMenu->id);
        return redirect('/gate/role-menu')->with('status', 'a role-menu data has been deleted!');
    }
}

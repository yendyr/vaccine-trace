<?php

namespace Modules\Gate\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Menu;
use Modules\Gate\Entities\Role;
use Modules\Gate\Entities\RoleMenu;
use Yajra\DataTables\DataTables;

class RoleMenuController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(RoleMenu::class, 'roleMenu');
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Menu::latest()->get();
            $tables =  DataTables::of($data)
                ->addColumn('view_menu', function ($row){
                    if ($row->add == 1){
                        return "<input type='checkbox' disabled>";
                    }
                    return null;
                })
                ->addColumn('add_column', function ($row){
                    if ($row->add == 1){
                        return "<input type='checkbox' disabled>";
                    }
                    return null;
                })
                ->addColumn('update_column', function ($row){
                    if ($row->update == 1){
                        return "<input type='checkbox' disabled>";
                    }
                    return null;
                })
                ->addColumn('delete_column', function ($row){
                    if ($row->delete == 1){
                        return "<input type='checkbox' disabled>";
                    }
                    return null;
                })
                ->addColumn('print_column', function ($row){
                    if ($row->print == 1){
                        return "<input type='checkbox' disabled>";
                    }
                    return null;
                })
                ->addColumn('approval_column', function ($row){
                    if ($row->approval >= 1){
                        $checkboxes = '';
                        for ($i = 1; $i <= $row->approval; $i++){
                            $checkboxes .= ($i . "<input type='checkbox' disabled>   ");
                        }
                        return $checkboxes;
                    }
                    return null;
                })
                ->escapeColumns([])
                ->make(true);

            return $tables;
        }

        return view('gate::pages.role-menu.index');
    }

    public function fetch($roleId, Request $request){
        $roleMenus = DB::table('role_menus')->get()->where('role_id', $roleId);
        $menuIds = DB::table('role_menus')->select('menu_id')->where('role_id', $roleId)->distinct()->get();
        if (count($menuIds) == 0){
            $menuID = null;
        } else {
            foreach ($menuIds as $idx => $menuId){
                $menuID[$idx+1] = $menuId->menu_id;
            }
        }

        if ($request->ajax()) {
            $data = Menu::latest();
            $tables =  DataTables::of($data)
                ->addColumn('menu_text', function ($row) use ($menuID){ //looping tiap menuRow
                    if ($menuID == null || ($menuID != null && !in_array($row->id, $menuID))){
                        //jika role bersangkutan tidak memiliki role menu
                        return $row->menu_text;
                    } elseif ($menuID != null && in_array($row->id, $menuID)){
                        return $row->menu_text;
                    }
                })
                ->addColumn('view_menu', function ($row) use ($menuID){ //looping tiap menuRow
                    if ($menuID == null || ($menuID != null && !in_array($row->id, $menuID))){
                        //jika role bersangkutan tidak memiliki role menu
                        return '<input name="index[' . $row->id . ']" type="checkbox" value="1" data-toggle="collapse" data-target="#role-menu' . $row->id . '">';
                    } elseif ($menuID != null && in_array($row->id, $menuID)){
                        return ('<input checked name="index[' .$row->id. ']"
                                type="checkbox" value="1" data-toggle="collapse" data-target="#role-menu' .$row->id. '">');
                    }
                })
                ->addColumn('add_column', function ($row) use ($menuID, $roleMenus){
                    $roleMenuRow = $roleMenus->where('menu_id', $row->id)->first();
                    if ($menuID == null || ($menuID != null && !in_array($row->id, $menuID))){
                        //jika role bersangkutan tidak memiliki role menu
                        return '<input '. (($row->add == 1) ? " " : "hidden ") . 'name="add[' . $row->id . ']" type="checkbox" value="1" id="role-menu' . $row->id . '" class="collapse">';
                    } elseif ($menuID != null && in_array($row->id, $menuID)){
                        if ($row->add == 1){
                            return '<input name="add[' .$row->id. ']" type="checkbox" value="1"  id="role-menu' .$row->id. '"'
                                .(($roleMenuRow->add == 1) ? "checked" : "") . ' class="collapse show">';
                        }
                    }
                })
                ->addColumn('update_column', function ($row) use ($menuID, $roleMenus){
                    $roleMenuRow = $roleMenus->where('menu_id', $row->id)->first();
                    if ($menuID == null || ($menuID != null && !in_array($row->id, $menuID))){
                        //jika role bersangkutan tidak memiliki role menu
                        return '<input '. (($row->update == 1) ? " " : "hidden ") . 'name="update[' . $row->id . ']" type="checkbox" value="1" id="role-menu' . $row->id . '" class="collapse">';
                    } elseif ($menuID != null && in_array($row->id, $menuID)){
                        if ($row->update == 1){
                            return '<input name="update[' .$row->id. ']" type="checkbox" value="1"  id="role-menu' .$row->id. '"'
                                .(($roleMenuRow->update == 1) ? "checked" : "") . ' class="collapse show">';
                        }
                    }
                })
                ->addColumn('delete_column', function ($row) use ($menuID, $roleMenus){
                    $roleMenuRow = $roleMenus->where('menu_id', $row->id)->first();
                    if ($menuID == null || ($menuID != null && !in_array($row->id, $menuID))){
                        //jika role bersangkutan tidak memiliki role menu
                        return '<input '. (($row->delete == 1) ? " " : "hidden ") . 'name="delete[' . $row->id . ']" type="checkbox" value="1" id="role-menu' . $row->id . '" class="collapse">';
                    } elseif ($menuID != null && in_array($row->id, $menuID)){
                        if ($row->delete == 1){
                            return '<input name="delete[' .$row->id. ']" type="checkbox" value="1"  id="role-menu' .$row->id. '"'
                                .(($roleMenuRow->delete == 1) ? "checked" : "") . ' class="collapse show">';
                        }
                    }
                })
                ->addColumn('print_column', function ($row) use ($menuID, $roleMenus){
                    $roleMenuRow = $roleMenus->where('menu_id', $row->id)->first();
                    if ($menuID == null || ($menuID != null && !in_array($row->id, $menuID))){
                        //jika role bersangkutan tidak memiliki role menu
                        return '<input '. (($row->print == 1) ? " " : "hidden ") . 'name="print[' . $row->id . ']" type="checkbox" value="1" id="role-menu' . $row->id . '" class="collapse">';
                    } elseif ($menuID != null && in_array($row->id, $menuID)){
                        if ($row->print == 1){
                            return '<input name="print[' .$row->id. ']" type="checkbox" value="1"  id="role-menu' .$row->id. '"'
                                .(($roleMenuRow->print == 1) ? "checked" : "") . ' class="collapse show">';
                        }
                    }
                })
                ->addColumn('approval_column', function ($row) use ($menuID, $roleMenus){
                    $roleMenuRow = $roleMenus->where('menu_id', $row->id)->first();
                    if( isset($roleMenuRow->approval) ) {
                        $approvalArr = json_decode($roleMenuRow->approval,true);
                        if( is_array($approvalArr) ){
                            $checkboxes = '';
                            if ($row->approval >= 1){
                                for ($i = 1; $i <= $row->approval; $i++){
                                    $checkboxes .= ('<label id="role-menu' .$row->id. '" class="collapse show">Lv. ' .$i.' 
                                    <input name="approval[' .$row->id. '][' .$i. ']" type="checkbox" value="' .$i. '"  ' .((in_array($i, $approvalArr)) ? "checked" : "") . ' >&nbsp;</label>');
                                }
                                return $checkboxes;
                            }
                        } else {
                            $checkboxes = '';
                            for ($i = 1; $i <= $row->approval; $i++){
                                $checkboxes .= ('<label id="role-menu' .$row->id. '" class="collapse show">Lv. ' .$i.' 
                                <input name="approval[' .$row->id. '][' .$i. ']" type="checkbox" value="' .$i. '"  ' .(($row->approval >= 1) ? "" : " hidden") . ' >&nbsp;</label>');
                            }
                            return $checkboxes;
                        }
                    } else {
                        $checkboxes = '';
                        for ($i = 1; $i <= $row->approval; $i++){
                            $checkboxes .= ('<label id="role-menu' .$row->id. '" class="collapse">Lv. ' .$i.' 
                            <input name="approval[' .$row->id. '][' .$i. ']" type="checkbox" value="' .$i. '"  ' .(($row->approval >= 1) ? "" : " hidden") . ' >
                            </label><br>');
                        }
                        return $checkboxes;
                    }
                })
                ->escapeColumns([])
                ->make(true);

            return $tables;
        }
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
        $collection = RoleMenu::where('role_id', $request->role)->pluck('id');
        RoleMenu::whereIn('id', $collection->toArray())->forceDelete();
        $collectionMenu = DB::table('menus')->select('id')->orderBy('id')->get()->toArray();

        foreach ($collectionMenu as $i => $menu){
            if (isset($request->index[$i+1])){
                $queryMenu = DB::table('menus')->select('menu_link')->where('id', $menu->id)->first();
                if (isset($request->approval[$i+1])){
//                    foreach ($request->approval[$i+1] as $idx => $checked){
//                        $approvalData[intval($idx)] = intval($checked);
//                    }
                    $approvalData = json_encode($request->approval[$i+1]);
                }
                if (isset($request->process[$i+1])){
                    $processData = json_encode($request->process[$i+1]);
                }
                $create = RoleMenu::create([
                    'uuid' => Str::uuid(),
                    'role_id' => $request->role,
                    'menu_id' => $menu->id,
                    'menu_link' => $queryMenu->menu_link,
                    'add' => ( isset($request->add[$i+1]) ? intval($request->add[$i+1]) : 0),
                    'update' => ( isset($request->update[$i+1]) ? intval($request->update[$i+1]) : 0),
                    'delete' => ( isset($request->delete[$i+1]) ? intval($request->delete[$i+1]) : 0),
                    'print' => ( isset($request->print[$i+1]) ? intval($request->print[$i+1]) : 0),
                    'approval' => ( isset($request->approval[$i+1]) ? $approvalData : json_encode(0) ),
                    'process' => ( isset($request->process[$i+1]) ? $processData : json_encode(0) ),
                    'status' => 1,
                    'owned_by' => $request->user()->company_id,
                    'created_by' => $request->user()->id,
                ]);
            }
        }

        return response()->json(['success' => 'Data updated successfully.']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($roleId, Request $request)
    {
        $menus = Menu::all();
        $role = Role::pluck('role_name', 'id');

        return view('gate::pages.role-menu.index', compact(['roleMenus', 'role', 'menus', 'roleId', 'menuID']));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(RoleMenu $role_menu)
    {
        $role = $role_menu->role;

        $selectedRoleMenus = DB::table('role_menus')->where('role_id', $role->id)->get();

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
        $request->validate([
            'role' => ['required', 'integer'],
            'menu' => ['required', 'integer'],
            'add' => ['integer'],
            'update' => ['integer'],
            'delete' => ['integer'],
        ]);

        $menu = Menu::all()->find($request->menu);

        RoleMenu::where('id', $roleMenu->id)
            ->first()->update([
                'role_id' => $request->role,
                'menu_id' => $request->menu,
                'menu_link' => $menu->menu_link,
                'add' => intval($request->add),
                'update' => intval($request->update),
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
    public function destroy(RoleMenu $RoleMenu)
    {
        $currentRow = RoleMenu::where('id', $RoleMenu->id)->first();
        $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        RoleMenu::destroy($RoleMenu->id);
        return response()->json(['success' => 'Role Menu Data has been Deleted']);
    }
}

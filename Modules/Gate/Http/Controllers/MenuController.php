<?php

namespace Modules\Gate\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Modules\Gate\Entities\Menu;
use Yajra\DataTables\DataTables;

class MenuController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Menu::class, 'menu');
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Menu::orderBy('group')->latest()->get();

            return Datatables::of($data)
                ->addColumn('icon', function ($row) {
                    return '<i class="fa ' . $row->menu_icon . '"></i> <span >' . $row->menu_icon . '</span></a>';
                })
                ->addColumn('actives', function ($row) {
                    $actives = json_decode($row->menu_actives);
                    $actives = (empty($actives)) ? [] : $actives;
                    return join(', ', $actives);
                })
                ->addColumn('parent', function ($row) {
                    $parent = Menu::select('id', 'menu_text')->find($row->parent_id);

                    return $parent->menu_text ?? null;
                })
                ->addColumn('action', function ($row) use ($request) {  
                    if ($request->user()->can('update', Menu::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        return view('components.action-button', compact(['updateable', 'updateValue']));
                    }

                    return '<p class="text-muted font-italic">no action authorized</p>';
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('gate::pages.menu.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('gate::pages.menu.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        $flag = true;

        $request->merge([
            'menu_actives' => json_encode($request->menu_actives),
            'add' => ($request->add == 'on') ? true : false,
            'update' => ($request->update == 'on') ? true : false,
            'delete' => ($request->delete == 'on') ? true : false,
            'print' => ($request->print == 'on') ? true : false,
            'process' => ($request->process == 'on') ? true : false,
            'status' => ($request->status == 'on') ? true : false,
            'approval' => ( empty($request->approval)) ? 0 : $request->approval,
        ]);

        $request->validate([
            'menu_text' => ['required', 'string', 'max:255'],
            'group' => ['required', 'string', 'max:255'],
            'menu_link' => ['required', 'string', 'max:255'],
            'menu_route' => ['required', 'string', 'max:255'],
            'menu_icon' => ['required', 'string', 'max:255'],
            'menu_actives' => ['required', 'JSON', 'max:255'],
            'menu_class' => ['string', 'max:255'],
            'parent_id' => ['exists:menus,id'],
            'add' => ['boolean'],
            'update' => ['boolean'],
            'delete' => ['boolean'],
            'print' => ['boolean'],
            'status' => ['boolean'],
            'approval' => ['numeric', 'min:0'],
        ]);

        $request->merge([
            'uuid' => Str::uuid(),
            'menu_actives' => json_decode($request->menu_actives)
        ]);

        $menu = Menu::create($request->all());
        if( empty($menu->id) ) $flag = false;
        
        if($flag){
            DB::commit();

            return response()->json(['status' => 'a menu data has been added!'], 200);
        }else{
            DB::rollBack();

            return response()->json(['status' => 'a menu failed to add!'], 200);
        }

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(Menu $menu)
    {
        return view('gate::pages.menu.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Menu $menu)
    {
        return view('gate::pages.menu.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Menu $menu)
    {
        DB::beginTransaction();
        $flag = true;

        $request->merge([
            'menu_actives' => json_encode($request->menu_actives),
            'add' => ($request->add == 'on') ? true : false,
            'update' => ($request->update == 'on') ? true : false,
            'delete' => ($request->delete == 'on') ? true : false,
            'print' => ($request->print == 'on') ? true : false,
            'process' => ($request->process == 'on') ? true : false,
            'status' => ($request->status == 'on') ? true : false,
            'approval' => ( empty($request->approval)) ? 0 : $request->approval,
        ]);

        $request->validate([
            'menu_text' => ['required', 'string', 'max:255'],
            'group' => ['required', 'string', 'max:255'],
            'menu_link' => ['required', 'string', 'max:255'],
            'menu_route' => ['required', 'string', 'max:255'],
            'menu_icon' => ['required', 'string', 'max:255'],
            'menu_actives' => ['required', 'JSON', 'max:255'],
            'menu_class' => ['string', 'max:255'],
            'parent_id' => ['exists:menus,id'],
            'add' => ['boolean'],
            'update' => ['boolean'],
            'delete' => ['boolean'],
            'print' => ['boolean'],
            'status' => ['boolean'],
            'approval' => ['numeric', 'min:0'],
        ]);

        $update = $menu->update($request->all());

        if( $update == false ) $flag = false;

        if($flag){
            DB::commit();

            return response()->json(['status' => 'a menu data has been updated!'], 200);
        }else{
            DB::rollBack();

            return response()->json(['status' => 'a menu failed to update!'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Menu $menu)
    {
        $menu->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        Menu::destroy($menu->id);
        return response()->json(['success' => 'Menu Data has been Deleted']);
    }

    public function select2Menu(Request $request)
    {
        $response = [];
        $response["pagination"]["more"] = true;
        $search = $request->search;
        
        $query = Menu::select('id', 'menu_text')->where('status', 1);
        if ($search != '') {
            $query = $query->where('menu_text', 'like', '%' . $search . '%');
        }
        if($request->page) {
            $menus = $query->paginate(10, ['*'], 'page');
        }else{
            $menus = $query->paginate(10);
        }
        foreach ($menus->items() as $menu) {
            $response['results'][] = [
                "id" => $menu->id,
                "text" => $menu->menu_text
            ];
        }

        return response()->json($response);
    }
}

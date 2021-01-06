<?php

namespace Modules\Gate\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Menu;
use Yajra\DataTables\DataTables;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;

class MenuController extends Controller
{
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

                    return '<p class="text-muted">no action authorized</p>';
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

        $request->validate([
            'menu_text' => ['required', 'string', 'max:255'],
            'group' => ['required', 'string', 'max:255'],
            'menu_link' => ['required', 'string', 'max:255'],
            'menu_route' => ['required', 'string', 'max:255'],
            'menu_icon' => ['required', 'string', 'max:255'],
            'menu_actives' => ['required', 'array', 'max:255'],
            'menu_class' => ['string', 'max:255'],
            'parent_id' => ['exists:menus,id'],
        ]);

        $request->merge([
            'uuid' => Str::uuid(),
            'menu_actives' => json_decode($request->menu_actives)
        ]);

        $menu = Menu::create($request->all());
        if( empty($menu->id) ) $flag = false;
        
        if($flag){
            DB::commit();

            return redirect('/gate/menu')->with('status', 'a menu data has been added!');
        }else{
            DB::rollBack();

            return redirect('/gate/menu')->with('status', 'a menu failed to add!');
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

        $request->validate([
            'menu_text' => ['required', 'string', 'max:255'],
            'group' => ['required', 'string', 'max:255'],
            'menu_link' => ['required', 'string', 'max:255'],
            'menu_route' => ['required', 'string', 'max:255'],
            'menu_icon' => ['required', 'string', 'max:255'],
            'menu_actives' => ['required', 'array', 'max:255'],
            'menu_class' => ['string', 'max:255'],
            'parent_id' => ['exists:menus,id'],
        ]);

        $update = $menu->update($request->all());

        if( $update == false ) $flag = false;

        if($flag){
            DB::commit();

            return redirect('/gate/menu')->with('status', 'a menu data has been updated!');
        }else{
            DB::rollBack();

            return redirect('/gate/menu')->with('status', 'a menu failed to update!');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Menu $menu)
    {
        Menu::destroy($menu->id);
        return redirect('/gate/menu')->with('status', 'a menu data has been deleted!');
    }

    public function select2Menu(Request $request)
    {
        $search = $request->q;

        $query = Menu::select('id', 'menu_text')->where('status', 1);
        if ($search != '') {
            $query = $query->where('menu_text', 'like', '%' . $search . '%');
        }
        $menus = $query->get();
        $response = [];

        foreach ($menus as $menu) {
            $response['results'][] = [
                "id" => $menu->id,
                "text" => $menu->menu_text
            ];
        }

        return response()->json($response);
    }
}

<?php

namespace Modules\Gate\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Menu;
use Yajra\DataTables\DataTables;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
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
                ->addColumn('action', function($row) use ($request) {
                    if($request->user()->can('update', Role::class)) {
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
        $request->validate([
            'menu_link' => ['required', 'string', 'max:255'],
            'parent' => ['required', 'string', 'max:255'],
        ]);

        $menu = new Menu();
        $menu->uuid = Str::uuid();
        $menu->menu_link = $request->menu_link;
        $menu->parent = $request->parent;
        $menu->status = 1;
        $menu->owned_by = $request->user()->company_id;
        $menu->created_by = $request->user()->id;
        $menu->save();

        return redirect('/gate/menu')->with('status', 'a menu data has been added!');
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
        $request->validate([
            'menu_link' => ['required', 'string', 'max:255'],
            'parent' => ['required', 'string', 'max:255'],
        ]);
        Menu::where('id', $menu->id)
            ->update([
                'menu_link' => $request->menu_link,
                'parent' => $request->parent,
                'updated_by' => $request->user()->id,
            ]);

        return redirect('/gate/menu')->with('status', 'a menu data has been updated!');
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
}

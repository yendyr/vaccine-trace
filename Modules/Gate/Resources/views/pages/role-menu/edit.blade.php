@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Role Menu'])
        <li class="breadcrumb-item">
            <a href="/gate/role-menu">Role Menu</a>
        </li>
        <li class="breadcrumb-item active">
            <a>Edit Role Menu</a>
        </li>
    @endcomponent
@endsection

@section('content')
    @component('gate::components.edit', ['action' => '/gate/role-menu/', 'row' => $roleMenu, 'name' => 'Role Menu'])
        @slot('formEdit')
{{--            <div class="form-group row">--}}
{{--                <label class="col-sm-2 col-form-label">Role</label>--}}
{{--                <div class="col-sm-4">--}}
{{--                    <select class="form-control m-b @error('role') is-invalid @enderror" name="role">--}}
{{--                        @foreach($role as $id => $role_name)--}}
{{--                            <option {{ ($id == $roleMenu->role_id) ? 'selected' : '' }} value="{{$id}}">{{$role_name}}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                    @error('role')--}}
{{--                    <div class="invalid-feedback">{{$message}}</div>--}}
{{--                    @enderror--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Role : </label>
                <div class="col-sm-4">
                    <input name="role" type="text" disabled class="form-control" value="{{$role->role_name}}">
                </div>
            </div>

            <div class="form-group row align-items-center">
                <label class="col-sm-2 col-form-label">Module Privileges</label>
                <div class="col-sm-4">
                    <div id="accordion">
                        @php $indexModule = 0; @endphp
                        @foreach($parents as $parentRow)
                            @if($parentRow != null)
                                @php $indexModule++; @endphp
                                <div class="card">
                                    <div class="card-header text-center">
                                        <a class="card-link" data-toggle="collapse" href="#collapse{{$indexModule}}">
                                            {{$parentRow->parent}}
                                        </a>
                                    </div>
                                    <div id="collapse{{$indexModule}}" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>Menu Text</th>
                                                    <th colspan="3">Permissions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php $sign = 0; @endphp
                                                @foreach($selectedRoleMenus as $roleMenuRow)
                                                    <tr>
                                                        @php
                                                            $menu = \Modules\Gate\Entities\Menu::where('id', $roleMenuRow->menu_id)->first();
                                                        @endphp
                                                        <th class="border-right">
                                                            <label>
                                                                <input @php if (isset($roleMenuRow->menu_link)) {echo 'checked'; $checked = 1;} @endphp data-toggle="collapse" data-target="#demo[{{$roleMenuRow->id}}]" name="index[{{$roleMenuRow->id}}]" type="checkbox" value="{{ isset($roleMenuRow->menu_link) ? '' : $roleMenuRow->menu_link}}"> {{$menu->menu_text}}
                                                            </label>
                                                        </th>
                                                        <div id="collapsedItem">
                                                            <td id="demo[{{$roleMenuRow->id}}]" class="collapse {{ ($checked == 1) ? 'show' : '' }}">
                                                                <label> <input name="add[{{$roleMenuRow->id}}]" type="checkbox" {{ ($roleMenuRow->add == 1) ? 'checked' : '' }} value="{{ ($roleMenuRow->add == 1) ? '' : '1' }}"> Add </label>
                                                            </td>
                                                            <td id="demo[{{$roleMenuRow->id}}]" class="collapse {{ ($checked == 1) ? 'show' : '' }}">
                                                                <label> <input name="edit[{{$roleMenuRow->id}}]" type="checkbox" {{ ($roleMenuRow->edit == 1) ? 'checked' : '' }} value="{{ ($roleMenuRow->edit == 1) ? '' : '1' }}"> Edit </label>
                                                            </td>
                                                            <td id="demo[{{$roleMenuRow->id}}]" class="collapse {{ ($checked == 1) ? 'show' : '' }}">
                                                                <label> <input name="delete[{{$roleMenuRow->id}}]" type="checkbox" {{ ($roleMenuRow->delete == 1) ? 'checked' : '' }} value="{{ ($roleMenuRow->delete == 1) ? '' : '1' }}"> Delete </label>
                                                            </td>
                                                        </div>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

        @endslot
    @endcomponent
@endsection



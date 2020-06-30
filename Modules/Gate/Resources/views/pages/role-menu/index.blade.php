@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Role Menu'])
        <li class="breadcrumb-item active">
            <a href="/gate/role-menu">Role Menu</a>
        </li>
    @endcomponent
@endsection

@section('content')
    @component('gate::components.index', ['title' => 'Role Menu Data'])
        @slot('tableContent')
        <div class="form-group row">
            <label onclick="getChange()" class="col-sm-1 col-form-label text-dark">ROLE</label>
            <div class="col-sm-3">
                <select class="form-control m-b" name="role">
                    <option {{ ($roleId == null) ? 'selected' : '' }} disabled>-- choose a role --</option>
                    @foreach($role as $id => $role_name)
                        <option onclick="setRoleId({{$id}})" {{ ($id == $roleId) ? 'selected' : '' }} value="{{$id}}">{{$role_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button onclick="sendRole()" class="btn btn-block btn-success"><strong>Choose Role</strong></button>
            </div>
        </div>

        <div class="table-responsive">
        <form action="/gate/role-menu" method="POST">
            @csrf
            <table class="table table-hover dataTables-example">
                <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Parent Menu</th>
                    <th>Menu Link</th>
                    <th>Menu Text</th>
                    <th>Add</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                    @php $i=1; @endphp
                    @if(!isset($roleMenus))
                        @foreach($menus as $menuRow)
                            <tr class="text-center">
                                <td><?= $i;$i++;?></td>
                                <td>{{$menuRow->parent}}</td>
                                <td>{{$menuRow->menu_link}}</td>
                                <td>{{$menuRow->menu_text}}</td>
                                <td>
                                    <input type="checkbox" disabled>
                                </td>
                                <td>
                                    <input type="checkbox" disabled>
                                </td>
                                <td>
                                    <input type="checkbox" disabled>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        @php $idx = 0; @endphp
                        <input type="text" name="role" hidden value="{{$roleId}}" >
                        @foreach($menus as $menuRow)
                            <input type="text" name="menu[{{($idx+1)}}]" hidden value="{{$menuRow->id}}" >
                            <tr class="text-center">
                                <td><?= ($idx+1);++$idx;?></td>
                                <td>{{$menuRow->parent}}</td>
                                <td>{{$menuRow->menu_link}}</td>
                                @if($menuID != null)
                                    @if(in_array($menuRow->id, $menuID))
                                        @php
                                            $roleMenuRow = $roleMenus->where('menu_id', $menuRow->id)->first();
                                        @endphp
                                        <td>
                                            <label>{{$menuRow->menu_text}}
                                                <input onchange="reaction({{$menuRow->id}})" @php echo 'checked'; $checked = 1; @endphp name="index[{{$menuRow->id}}]"
                                                       type="checkbox" value="1" data-toggle="collapse" data-target="#demo{{$idx}}">
                                            </label>
                                        </td>
                                        <td>
                                        @if($menuRow->add == 1)
                                            <input {{ ($checked == 1) ? '' : 'hidden' }} name="add[{{$menuRow->id}}]" type="checkbox" value="1"  id="demo{{$idx}}"
                                                   {{ ($roleMenuRow->add == 1) ? 'checked' : '' }} class="collapse {{ ($checked == 1) ? 'show' : '' }}">
                                        @endif
                                        </td>
                                        <td>
                                        @if($menuRow->edit == 1)
                                                <input {{ ($checked == 1) ? '' : 'hidden' }} name="edit[{{$menuRow->id}}]" type="checkbox" value="1"  id="demo{{$idx}}"
                                                       {{ ($roleMenuRow->edit == 1) ? 'checked' : '' }} class="collapse {{ ($checked == 1) ? 'show' : '' }}">
                                        @endif
                                        </td>
                                        <td>
                                        @if($menuRow->edit == 1)
                                                <input {{ ($checked == 1) ? '' : 'hidden' }} name="delete[{{$menuRow->id}}]" type="checkbox" value="1"  id="demo{{$idx}}"
                                                       {{ ($roleMenuRow->delete == 1) ? 'checked' : '' }} class="collapse {{ ($checked == 1) ? 'show' : '' }}">
                                        @endif
                                        </td>
                                    @else {{-- untuk menu yang tidak dimiliki di role menu bersangkutan --}}
                                        <td>
                                            <label>{{$menuRow->menu_text}}
                                                <input onchange="reaction({{$menuRow->id}})" name="index[{{$menuRow->id}}]" type="checkbox" value="1" data-toggle="collapse" data-target="#demo{{$idx}}">
                                            </label>
                                        </td>
                                        <td>
                                            @if($menuRow->add == 1)
                                                <input {{ ($menuRow->add == 1) ? '' : 'hidden' }} name="add[{{$menuRow->id}}]" type="checkbox" value="1" id="demo{{$idx}}" class="collapse">
                                            @endif
                                        </td>
                                        <td>
                                            @if($menuRow->edit == 1)
                                                <input {{ ($menuRow->edit == 1) ? '' : 'hidden' }} name="edit[{{$menuRow->id}}]" type="checkbox" value="1" id="demo{{$idx}}" class="collapse">
                                            @endif
                                        </td>
                                        <td>
                                            @if($menuRow->delete == 1)
                                                <input {{ ($menuRow->delete == 1) ? '' : 'hidden' }} name="delete[{{$menuRow->id}}]" type="checkbox" value="1" id="demo{{$idx}}" class="collapse">
                                            @endif
                                        </td>
                                    @endif
                                @else {{-- untuk role menu yg gapunya data samasekali --}}
                                    <td>
                                        <label>{{$menuRow->menu_text}}
                                            <input onchange="reaction({{$menuRow->id}})" name="index[{{$menuRow->id}}]" type="checkbox" value="1" data-toggle="collapse" data-target="#demo{{$idx}}">
                                        </label>
                                    </td>
                                    <td>
                                        @if($menuRow->add == 1)
                                            <input {{ ($menuRow->add == 1) ? '' : 'hidden' }} name="add[{{$menuRow->id}}]" type="checkbox" value="1" id="demo{{$idx}}" class="collapse">
                                        @endif
                                    </td>
                                    <td>
                                        @if($menuRow->edit == 1)
                                            <input {{ ($menuRow->edit == 1) ? '' : 'hidden' }} name="edit[{{$menuRow->id}}]" type="checkbox" value="1" id="demo{{$idx}}" class="collapse">
                                        @endif
                                    </td>
                                    <td>
                                        @if($menuRow->delete == 1)
                                            <input {{ ($menuRow->delete == 1) ? '' : 'hidden' }} name="delete[{{$menuRow->id}}]" type="checkbox" value="1" id="demo{{$idx}}" class="collapse">
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach

                    @endif
                </tbody>
                <tfoot>
                    <tr></tr>
                </tfoot>
            </table>

            <div class="form-group row col-sm-12 justify-content-center text-center">
                <div class="col-sm-4">
                    <button class="btn btn-block btn-primary" type="submit">SAVE CHANGES</button>
                </div>
            </div>

            </form>

        </div>
        @endslot
    @endcomponent


    @push('footer-scripts')
    <script>
        var roleID = null;
        function setRoleId(roleId) {
            roleID = roleId
        }

        function sendRole() {
            var url = '{{ route("gate.role-menu.index") }}' + '/' + roleID;
            document.location.href=url;
        }

        function reaction(menuId) {
            if($('input[name="index[' + menuId + ']"]').is(":not(:checked)")){
                //$('input[name="index[' + menuId + ']"]').attr('value', 0);
                $('input[name="add[' + (menuId) + ']"]').prop('checked', false);
                // $('input[name="add[' + (menuId) + ']"]').hide();
                $('input[name="edit[' + (menuId) + ']"]').prop('checked', false);
                // $('input[name="edit[' + (menuId) + ']"]').hide();
                $('input[name="delete[' + (menuId) + ']"]').prop('checked', false);
                // $('input[name="delete[' + (menuId) + ']"]').hide();
            } else{
                //$('input[name="index[' + menuId + ']"]').attr('value', 1);
                // $('input[name="add[' + (menuId) + ']"]').show();
                // $('input[name="edit[' + (menuId) + ']"]').show();
                // $('input[name="delete[' + (menuId) + ']"]').show();
            }
        }

    </script>
    @endpush
@endsection

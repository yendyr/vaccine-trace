@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Role Menu'])
        <li class="breadcrumb-item">
            <a href="/gate/role-menu">Role Menu</a>
        </li>
        <li class="breadcrumb-item active">
            <a>Create Role Menu</a>
        </li>
    @endcomponent
@endsection

@section('content')
    @component('gate::components.create', ['action' => '/gate/role-menu', 'name' => 'Role Menu'])
        @slot('formCreate')
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Role</label>
                <div class="col-sm-4">
                    <select class="form-control m-b @error('role') is-invalid @enderror" name="role">
                        <option selected disabled>-- choose a role --</option>
                        @foreach($role as $id => $role_name)
                            <option value="{{$id}}">{{$role_name}}</option>
                        @endforeach
                    </select>
                    @error('role')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row align-items-center">
                <label class="col-sm-2 col-form-label">Module Privileges</label>
                <div class="col-sm-4">
                    <div id="accordion">
                        @php $indexModule = 0; @endphp
                        @foreach($parent as $key => $parentRow)
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
                                            @foreach($menu as $menuRow)
                                                <tr>
                                                    <th class="border-right">
                                                        <label id="collapsibling[{{$key}}]">
                                                            <input onclick="myFunction()" class="" data-toggle="collapse" data-target="#demo{{$menuRow->id}}" name="index[{{$menuRow->id}}]" type="checkbox" value="{{$menuRow->menu_link}}"> {{$menuRow->menu_text}}
                                                        </label>
                                                    </th>
                                                    <div id="collapsibled[{{$key}}]">
                                                        <td>
                                                            <label> <input name="add[{{$menuRow->id}}]" type="checkbox" value="1"> Add </label>
                                                        </td>
                                                        <td>
                                                            <label> <input name="edit[{{$menuRow->id}}]" type="checkbox" value="1"> Edit </label>
                                                        </td>
                                                        <td>
                                                            <label> <input name="delete[{{$menuRow->id}}]" type="checkbox" value="1"> Delete </label>
                                                        </td>
                                                    </div>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

{{--            <div class="form-group row align-items-center">--}}
{{--                <label class="col-sm-2 col-form-label">Privileges</label>--}}
{{--                <div class="col-sm-6">--}}
{{--                    @foreach($menus as $id => $menuName)--}}
{{--                        <div class="i-checks">--}}
{{--                            <label> <input data-toggle="collapse" data-target="#demo" class="@error('add') is-invalid @enderror" name="add" type="checkbox" value="1"> Add </label>--}}
{{--                            @error('add')--}}
{{--                            <div class="invalid-feedback">{{$message}}</div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                        <div id="demo" class="collapse">--}}
{{--                            Lorem ipsum dolor sit amet, consectetur adipisicing elit,--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            </div>--}}


{{--            <div class="form-group row align-items-center"><label class="col-sm-2 col-form-label">Privileges</label>--}}
{{--                <div class="col-sm-10">--}}
{{--                    <div class="i-checks">--}}
{{--                        <label> <input class="@error('add') is-invalid @enderror" name="add" type="checkbox" value="1"> Add </label>--}}
{{--                        @error('add')--}}
{{--                        <div class="invalid-feedback">{{$message}}</div>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                    <div class="i-checks">--}}
{{--                        <label> <input class="@error('edit') is-invalid @enderror" name="edit" type="checkbox" value="1"> Edit </label>--}}
{{--                        @error('edit')--}}
{{--                        <div class="invalid-feedback">{{$message}}</div>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                    <div class="i-checks">--}}
{{--                        <label> <input class="@error('delete') is-invalid @enderror" name="delete" type="checkbox" value="1"> Delete </label>--}}
{{--                        @error('delete')--}}
{{--                        <div class="invalid-feedback">{{$message}}</div>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

        @endslot
    @endcomponent
    <script>
        // var bla = jquery("#collapsibled[0]");
        // console.log(bla);
        // $("#collapsibled").hide();
        // function myFunction(){
        // }
        // $( "#collapsibling" ).click(function() {
        //     $("#collapsibled").show();
        // });

    </script>
@endsection



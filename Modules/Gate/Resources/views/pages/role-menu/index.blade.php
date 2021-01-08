@extends('layouts.master')

@section('content')
    <div class="form-group row">
        <label class="col-sm-1 col-form-label text-dark">ROLE</label>
        <div class="col-sm-3">
            <select class="select2_role form-control m-b" name="role">
{{--                <option {{ ($roleId == null) ? 'selected' : '' }} disabled>-- selected role --</option>--}}
{{--                @foreach($role as $id => $role_name)--}}
{{--                    <option onclick="setRoleId({{$id}})" {{ ($id == $roleId) ? 'selected' : '' }} value="{{$id}}">{{$role_name}}</option>--}}
{{--                @endforeach--}}
            </select>
        </div>
    </div>
    @component('components.crud-form.index', ['title' => 'Role Menu Datalist'])
        @slot('tableContent')
        <div id="form_result" role="alert"></div>

        <div class="table-responsive" id="rolemenu">
            <form id="rolemenu-form">
                @can('create', Modules\Gate\Entities\RoleMenu::class)
                    <div class="form-group row col-sm-12 justify-content-start align-items-start text-center">
                        <div class="col-sm-2">
                            <button class="ladda-button ladda-button-submit btn btn-primary"  data-style="zoom-in" type="submit" id="saveButton">
                                <strong>Save Changes</strong>
                            </button>
                        </div>
                    </div>
                @endcan
                <input type="hidden" name="role" value="" id="role-input">
                <table data-ajaxsource="/gate/role-menu" id="rolemenu-table" class="table table-hover text-center">
                    <thead>
                        <tr>
                            <th>Parent Menu</th>
                            <th>Menu Link</th>
                            <th>Menu Text</th>
                            <th>Add</th>
                            <th>Update</th>
                            <th>Delete</th>
                            <th>Print</th>
                            <th>Approval</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr></tr>
                    </tfoot>
                </table>
            </form>

        </div>
        @endslot

    @endcomponent

    @include('gate::components.role-menu._script')

@endsection

@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
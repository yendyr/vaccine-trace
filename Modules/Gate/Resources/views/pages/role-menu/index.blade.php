@extends('layouts.master')

@section('content')
<form id="rolemenu-form">
    <div class="form-group row">
        <label class="col-sm-1 col-form-label text-dark">Role Name</label>
        <div class="col-sm-3">
            <select class="select2_role form-control m-b" name="role">
            </select>
        </div>
        <div class="col-md-7">
            @can('create', Modules\Gate\Entities\RoleMenu::class) 
                <button class="ladda-button ladda-button-submit btn btn-primary"  data-style="zoom-in" type="submit" id="saveButton">
                    <strong>Save Changes</strong>
                </button>
            @endcan
        </div>
    </div>

    @component('components.crud-form.index', [
                    'title' => 'Role Menu Datalist',
                    'tableId' => 'rolemenu-table',
                    'ajaxSource' => '/gate/role-menu'])

        
            <input type="hidden" name="role" value="" id="role-input">
            @slot('tableContent')
                <th>Parent Menu</th>
                <th>Menu Link</th>
                <th>Menu Text</th>
                <th>Add</th>
                <th>Update</th>
                <th>Delete</th>
                <th>Print</th>
                <th>Approval</th>
            @endslot
    @endcomponent
@include('gate::components.role-menu._script')
</form>
@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
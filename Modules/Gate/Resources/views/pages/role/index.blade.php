@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Role Datalist'])
    @endcomponent

    @include('gate::components.role.modal')

    @component('components.crud-form.index',[
        'title' => 'Role Datalist',
        'tableId' => 'role-table'])

        @slot('createButton')
            @can('create', Modules\Gate\Entities\Role::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Add Role
                </button>   
            @endcan
        @endslot

        @slot('tableContent')
            <th>Role Name</th>
            <th>Status</th>
            <th>Action</th>
        @endslot
    @endcomponent

    @include('gate::components.role._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
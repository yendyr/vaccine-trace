@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Role data'])
    @endcomponent

    @include('gate::components.role.modal')

    @component('gate::components.index', ['title' => 'Roles data'])
        @slot('tableContent')
            <div id="form_result" role="alert"></div>
            <div class="p-4 d-flex justify-content-end" style="font-size:14px;">
                @can('create', Modules\Gate\Entities\Role::class)
                    <button type="button" id="createRole" class="btn btn-primary"><i class="fa fa-plus-circle"></i>&nbsp;<strong>Role</strong></button>
                @endcan
            </div>
            <div class="table-responsive">
                <table id="role-table" class="table table-hover text-center">
                    <thead>
                        <tr class="text-center">
                            <th>Role Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr></tr>
                    </tfoot>
                </table>
            </div>
        @endslot
    @endcomponent

    @include('gate::components.role._script')

@endsection

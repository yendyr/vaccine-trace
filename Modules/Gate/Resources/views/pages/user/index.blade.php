@extends('layouts.master')

@push('header-scripts')
    <style>
        .select2-container.select2-container--default.select2-container--open {
            z-index: 9999999 !important;
        }
        .select2{
            width: 100% !important;
        }
    </style>
@endpush

@section('content')
    @component('components.delete-modal', ['name' => 'User data'])
    @endcomponent

    @include('gate::components.user.modal')

    @component('gate::components.index', ['title' => 'Users data'])
        @slot('tableContent')
            <div id="form_result"></div>
            <div class="p-4 d-flex justify-content-end" style="font-size:14px;">
                @can('create', Modules\Gate\Entities\User::class)
                    <button id="createUser" class="btn btn-primary" type="button"><i class="fa fa-plus-circle"></i>&nbsp;<strong>User</strong></button>
                @endcan
            </div>
            <div class="table-responsive">
                <table id="user-table" class="table table-hover text-center">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        @endslot
    @endcomponent

    @include('gate::components.user._script')

@endsection

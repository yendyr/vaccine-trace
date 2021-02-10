@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'User Datalist'])
    @endcomponent

    @include('gate::pages.user.modal')

    @component('components.crud-form.index',[
                    'title' => 'User Datalist',
                    'tableId' => 'user-table'])

        @slot('createButton')
            @can('create', Modules\Gate\Entities\User::class)
                <button id="createUser" class="btn btn-primary btn-lg" type="button">
                    <i class="fa fa-plus-circle"></i>&nbsp;Create New</button>
            @endcan
        @endslot

        @slot('tableContent')
            <th>Username</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Company</th>
            <th>Status</th>
            <th>Action</th>            
        @endslot

    @endcomponent

    @include('gate::components.user._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
    <style>
        .select2-container.select2-container--default.select2-container--open {
            z-index: 9999999 !important;
        }
        .select2{
            width: 100% !important;
        }
    </style>
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    <script src="{{ URL::asset('theme/js/plugins/pwstrength/pwstrength-bootstrap.min.js') }}"></script>
    @include('layouts.includes._footer-datatable-script')
@endpush
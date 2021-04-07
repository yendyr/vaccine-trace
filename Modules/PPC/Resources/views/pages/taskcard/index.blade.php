@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Task Card Datalist'])
    @endcomponent

    @include('ppc::pages.taskcard.modal')

    @component('components.crud-form.index',[
                    'title' => 'Task Card Datalist',
                    'tableId' => 'taskcard-table'])

        @slot('createButton')
            @can('create', Modules\PPC\Entities\Taskcard::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Create New
                </button>   
            @endcan
        @endslot    

        @slot('tableContent')
            <th>MPD Number</th>
            <th>Title</th>
            <th>Group</th>
            <th>Tag</th>
            <th>Type</th>
            <th>Instruction/Task Total</th>
            <th>Manhours Total</th>
            <th>Aircraft Type</th>
            <th>Skill</th>
            <th>Threshold</th>
            <th>Repeat</th>
            {{-- <th>Created By</th> --}}
            <th>Created At</th>
            {{-- <th>Last Updated By</th>
            <th>Last Updated At</th> --}}
            <th>Action</th>
        @endslot
    @endcomponent

    @include('ppc::components.taskcard._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
    <style>
        thead input {
            width: 100%;
        }
        tr.group,
        tr.group:hover {
            background-color: #aaa !important;
        }
    </style>
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Task Release Level Datalist'])
    @endcomponent

    @include('qualityassurance::pages.task-release-level.modal')

    @component('components.crud-form.index',[
                    'title' => 'Task Release Level Datalist',
                    'tableId' => 'task-release-level-table'])

        @slot('createButton')
            @can('create', Modules\QualityAssurance\Entities\TaskReleaseLevel::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Create New
                </button>   
            @endcan
        @endslot    

        @slot('tableContent')
            <th>Code</th>
            <th>Task Release Level Name</th>
            <th>Sequence Level</th>
            <th>Authorized Engineering Level</th>
            <th>Description/Remark</th>
            <th>Status</th>
            <th>Created By</th>
            <th>Created At</th>
            <th>Last Updated By</th>
            <th>Last Updated At</th>
            <th>Action</th>
        @endslot
    @endcomponent

    @include('qualityassurance::components.task-release-level._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
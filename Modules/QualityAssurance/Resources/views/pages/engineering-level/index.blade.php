@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Engineering Leveling Datalist'])
    @endcomponent

    @include('qualityassurance::pages.engineering-level.modal')

    @component('components.crud-form.index',[
                    'title' => 'Engineering Leveling Datalist',
                    'tableId' => 'engineering-level-table'])

        @slot('createButton')
            @can('create', Modules\QualityAssurance\Entities\EngineeringLevel::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Create New
                </button>   
            @endcan
        @endslot    

        @slot('tableContent')
            <th>Code</th>
            <th>Engineering Leveling Name</th>
            <th>Sequence Level</th>
            <th>Description/Remark</th>
            <th>Status</th>
            <th>Created By</th>
            <th>Created At</th>
            <th>Last Updated By</th>
            <th>Last Updated At</th>
            <th>Action</th>
        @endslot
    @endcomponent

    @include('qualityassurance::components.engineering-level._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
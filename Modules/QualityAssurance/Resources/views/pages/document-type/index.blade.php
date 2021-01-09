@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Document Type Datalist'])
    @endcomponent

    @include('qualityassurance::pages.document-type.modal')

    @component('components.crud-form.index', ['title' => 'Document Type Datalist']) 
        @slot('createButton')
            @can('create', Modules\QualityAssurance\Entities\DocumentType::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Create New
                </button>   
            @endcan
        @endslot    

        @slot('tableContent')
            <table id="document-type-table" class="table table-hover table-striped text-center" style="width:100%">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Document Type Name</th>
                        <th>Description/Remark</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th>Last Updated By</th>
                        <th>Last Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr></tr>
                </tfoot>
            </table>
        @endslot
    @endcomponent

    @include('qualityassurance::components.document-type._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
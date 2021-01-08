@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Document Type'])
    @can('create', Modules\QualityAssurance\Entities\DocumentType::class)
        <button type="button" id="createDocumentType" class="btn btn-primary btn-lg"><i class="fa fa-plus-circle"></i>&nbsp;Create New</button>
    @endcan
    @endcomponent
@endsection

@section('content')
    @component('components.delete-modal', ['name' => 'Document Type Datalist'])
    @endcomponent

    @include('qualityassurance::pages.document-type.modal')

    @component('components.crud-form.index', ['title' => 'Document Type Datalist'])
        @slot('tableContent')
            <div id="form_result" role="alert"></div>
            
            <div class="table-responsive">
                <table id="document-type-table" class="table table-hover table-striped text-center">
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
            </div>
        @endslot
    @endcomponent

    @include('qualityassurance::components.document-type._script')

@endsection

@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
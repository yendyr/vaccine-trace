@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Task Card Type'])
    @can('create', Modules\PPC\Entities\TaskcardType::class)
        <button type="button" id="createTaskcardType" class="btn btn-primary btn-lg"><i class="fa fa-plus-circle"></i>&nbsp;Create New</button>
    @endcan
    @endcomponent
@endsection

@section('content')
    @component('components.delete-modal', ['name' => 'Task Card Type Datalist'])
    @endcomponent

    @include('ppc::pages.taskcard.type.modal')

    @component('components.crud-form.index', ['title' => 'Task Card Type Datalist'])
        @slot('tableContent')
            <div id="form_result" role="alert"></div>
            
            <div class="table-responsive">
                <table id="taskcard-type-table" class="table table-hover table-striped text-center">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Task Card Type Name</th>
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

    @include('ppc::components.taskcard.type._script')

@endsection

@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb',
                ['name' => 'Task Card Type',
                'href' => '/ppc/taskcard-type',
                ])
        {{-- @can('create', \Modules\HumanResources\Entities\Employee::class) --}}
            <button id="createTaskcardType" class="btn btn-primary btn-lg" type="button">
                <i class="fa fa-plus-circle"></i>&nbsp;Add New Task Card Type</button>
        {{-- @endcan --}}
    @endcomponent
@endsection

@section('content')
@component('components.delete-modal', ['name' => 'Task Card Type Data'])
@endcomponent

@include('ppc::pages.taskcard.type.modal')

<div class="ibox">
    <div class="ibox-title text-center">
        <h5>Task Card Type Datalist</h5>
        <div class="ibox-tools">
            <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
            </a>
            <a class="fullscreen-link">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>
    <div class="ibox-content">
        <div class="table-responsive">
            <table id="taskcard-type-table" class="table table-hover text-center">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Task Card Type Name</th>
                        <th>Description/Remark</th>
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
    </div>
</div>

@include('ppc::components.taskcard-type._script')
@endsection

@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
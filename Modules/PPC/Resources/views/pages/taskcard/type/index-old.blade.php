@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb',
                ['name' => 'Task Card Type',
                'href' => '/ppc/taskcard/type',
                ])
        {{-- @can('create', \Modules\HumanResources\Entities\Employee::class) --}}
            <a href="{{ route('ppc.taskcard.type.create')}}" class="btn btn-primary btn-lg"><i class="fa fa-plus-circle"></i>&nbsp;Add New Task Card Type</a>
        {{-- @endcan --}}
    @endcomponent
@endsection

@section('content')
@component('components.delete-modal', ['name' => 'Task Card Type Data'])
@endcomponent

@component('components.crud-form.index', ['title' => 'Task Card Type Datalist'])
    @slot('tableContent')
            
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
    @endslot
@endcomponent

@include('ppc::components.taskcard.type._script')
@endsection

@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
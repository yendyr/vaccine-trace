@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Task Card Group Datalist'])
    @endcomponent

    @include('ppc::pages.taskcard-group.modal')

    @component('components.crud-form.index',[
                    'title' => 'Task Card Group Datalist',
                    'tableId' => 'taskcard-group-table'])

        @slot('createButton')
            @can('create', Modules\PPC\Entities\TaskcardGroup::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Create New
                </button>   
            @endcan
        @endslot    

        @slot('tableContent')
            <th>Code</th>
            <th>Task Card Group Name</th>
            <th>Parent Group Name</th>
            <th>Description/Remark</th>
            <th>Status</th>
            <th>Created By</th>
            <th>Created At</th>
            <th>Last Updated By</th>
            <th>Last Updated At</th>
            <th>Action</th>
        @endslot
    @endcomponent

    @include('ppc::components.taskcard-group._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush